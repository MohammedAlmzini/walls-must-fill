<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMainCampaignController extends Controller
{
    public function index()
    {
        $campaign = MainCampaign::first();
        return view('admin.main-campaign.index', compact('campaign'));
    }

    public function edit()
    {
        $campaign = MainCampaign::first();
        if (!$campaign) {
            $campaign = new MainCampaign();
        }
        return view('admin.main-campaign.edit', compact('campaign'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'collected_amount' => 'required|numeric|min:0',
            'supporters_count' => 'required|integer|min:0',
            'urgent_needs' => 'required|array',
            'urgent_needs.*' => 'required|string|max:255',
            'paypal_qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'whatsapp_number' => 'required|string|max:20',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $campaign = MainCampaign::first();
        if (!$campaign) {
            $campaign = new MainCampaign();
        }

        $data = $request->except(['paypal_qr_code']);

        // معالجة صورة QR code
        if ($request->hasFile('paypal_qr_code')) {
            // حذف الصورة القديمة إذا وجدت
            if ($campaign->paypal_qr_code && Storage::exists($campaign->paypal_qr_code)) {
                Storage::delete($campaign->paypal_qr_code);
            }

            $path = $request->file('paypal_qr_code')->store('qr', 'public');
            $data['paypal_qr_code'] = $path;
        }

        $campaign->fill($data);
        $campaign->save();

        return redirect()->route('admin.main-campaign.index')
            ->with('success', 'تم تحديث الحملة الرئيسية بنجاح');
    }

    public function show()
    {
        $campaign = MainCampaign::first();
        if (!$campaign) {
            abort(404);
        }
        return view('main-campaign.show', compact('campaign'));
    }
}
