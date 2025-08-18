<?php

namespace App\Http\Controllers;

use App\Models\MainCampaign;

class MainCampaignController extends Controller
{
    public function show()
    {
        $campaign = MainCampaign::where('is_active', true)->first();
        
        if (!$campaign) {
            abort(404);
        }

        return view('main-campaign.show', compact('campaign'));
    }
}
