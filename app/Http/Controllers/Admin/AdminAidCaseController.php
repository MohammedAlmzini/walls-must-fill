<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AidCase;
use App\Models\CaseImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminAidCaseController extends Controller
{
    public function index()
    {
        $cases = AidCase::latest()->paginate(15);
        return view('admin.cases.index', compact('cases'));
    }

    public function create()
    {
        return view('admin.cases.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['required','string'],
            'cover_image' => ['nullable','image','max:4096'],
            'qr_image' => ['nullable','image','max:4096'],
            'video_url' => ['nullable','url'],
            'whatsapp_number' => ['nullable','string','max:30'],
            'goal_amount' => ['nullable','numeric','min:0'],
            'collected_amount' => ['nullable','numeric','min:0'],
            'is_completed' => ['nullable','boolean'],
            'images.*' => ['nullable','image','max:4096'],
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('uploads/cases', 'public');
        }
        if ($request->hasFile('qr_image')) {
            $data['qr_image_path'] = $request->file('qr_image')->store('uploads/cases', 'public');
        }

        $case = AidCase::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']).'-'.Str::random(6),
            'description' => $data['description'],
            'cover_image_path' => $data['cover_image_path'] ?? null,
            'qr_image_path' => $data['qr_image_path'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'whatsapp_number' => $data['whatsapp_number'] ?? null,
            'goal_amount' => $data['goal_amount'] ?? null,
            'collected_amount' => $data['collected_amount'] ?? 0,
            'is_completed' => $request->boolean('is_completed', false),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('uploads/cases/gallery', 'public');
                CaseImage::create([
                    'aid_case_id' => $case->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.cases.index')->with('success', 'تم إضافة الحالة بنجاح.');
    }

    public function edit(AidCase $case)
    {
        $case->load('images');
        return view('admin.cases.edit', compact('case'));
    }

    public function update(Request $request, AidCase $case)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['required','string'],
            'cover_image' => ['nullable','image','max:4096'],
            'qr_image' => ['nullable','image','max:4096'],
            'video_url' => ['nullable','url'],
            'whatsapp_number' => ['nullable','string','max:30'],
            'goal_amount' => ['nullable','numeric','min:0'],
            'collected_amount' => ['nullable','numeric','min:0'],
            'is_completed' => ['nullable','boolean'],
            'images.*' => ['nullable','image','max:4096'],
        ]);

        if ($request->hasFile('cover_image')) {
            if ($case->cover_image_path) Storage::disk('public')->delete($case->cover_image_path);
            $case->cover_image_path = $request->file('cover_image')->store('uploads/cases', 'public');
        }
        if ($request->hasFile('qr_image')) {
            if ($case->qr_image_path) Storage::disk('public')->delete($case->qr_image_path);
            $case->qr_image_path = $request->file('qr_image')->store('uploads/cases', 'public');
        }

        $case->title = $data['title'];
        $case->description = $data['description'];
        $case->video_url = $data['video_url'] ?? null;
        $case->whatsapp_number = $data['whatsapp_number'] ?? null;
        $case->goal_amount = $data['goal_amount'] ?? null;
        $case->collected_amount = $data['collected_amount'] ?? 0;
        $case->is_completed = $request->boolean('is_completed', false);
        $case->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('uploads/cases/gallery', 'public');
                CaseImage::create([
                    'aid_case_id' => $case->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.cases.edit', $case)->with('success', 'تم تحديث الحالة.');
    }

    public function destroy(AidCase $case)
    {
        if ($case->cover_image_path) Storage::disk('public')->delete($case->cover_image_path);
        if ($case->qr_image_path) Storage::disk('public')->delete($case->qr_image_path);
        foreach ($case->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }
        $case->delete();
        return back()->with('success', 'تم حذف الحالة.');
    }
}