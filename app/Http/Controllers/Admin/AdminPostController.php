<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User; // إضافة
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::latest('created_at')->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'excerpt' => ['nullable','string','max:500'],
            'body' => ['nullable','string'],
            'image' => ['nullable','image','max:2048'],
            'youtube_url' => ['nullable','url'],
            'meta_description' => ['nullable','string','max:160'],
            'is_published' => ['nullable','boolean'],
            'published_at' => ['nullable','date'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('uploads/posts', 'public');
        }

        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        $data['is_published'] = $request->boolean('is_published', true);
        $data['published_at'] = $data['published_at'] ?? now();

        // اربط الكاتب فقط إذا كان الأدمن موجوداً فعلاً
        $adminId = $request->session()->get('admin_id');
        if ($adminId && User::where('id', $adminId)->where('is_admin', true)->exists()) {
            $data['user_id'] = $adminId;
        } else {
            $data['user_id'] = null; // منع فشل FK
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success','تم إنشاء التدوينة بنجاح.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'excerpt' => ['nullable','string','max:500'],
            'body' => ['nullable','string'],
            'image' => ['nullable','image','max:2048'],
            'youtube_url' => ['nullable','url'],
            'meta_description' => ['nullable','string','max:160'],
            'is_published' => ['nullable','boolean'],
            'published_at' => ['nullable','date'],
        ]);

        if ($request->hasFile('image')) {
            if ($post->image_path) Storage::disk('public')->delete($post->image_path);
            $data['image_path'] = $request->file('image')->store('uploads/posts', 'public');
        }

        $data['is_published'] = $request->boolean('is_published', true);
        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success','تم تحديث التدوينة.');
    }

    public function destroy(Post $post)
    {
        if ($post->image_path) Storage::disk('public')->delete($post->image_path);
        $post->delete();
        return back()->with('success','تم حذف التدوينة.');
    }
}