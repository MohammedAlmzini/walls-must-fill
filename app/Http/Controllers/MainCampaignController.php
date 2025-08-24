<?php

namespace App\Http\Controllers;

use App\Models\MainCampaign;
use App\Services\SEOService;

class MainCampaignController extends Controller
{
    public function show()
    {
        $campaign = MainCampaign::where('is_active', true)->first();
        
        if (!$campaign) {
            abort(404);
        }

        $locale = session('locale', 'ar');
        $seoMeta = SEOService::getPageMeta('main-campaign', [], $locale);
        
        return view('main-campaign.show', compact('campaign', 'seoMeta'));
    }
}
