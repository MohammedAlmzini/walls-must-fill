<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShipCampaignSurvey;
use Illuminate\Support\Facades\Validator;

class ShipCampaignController extends Controller
{
    public function show()
    {
        return view('ship-campaign.show');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'age' => 'required|integer|min:1|max:120',
            'question1_answer' => 'required|string|max:1000',
            'question2_answer' => 'required|string|max:1000',
            'question3_answer' => 'required|string|max:1000',
            'question4_answer' => 'required|string|max:1000',
            'question5_answer' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $survey = ShipCampaignSurvey::create($request->all());
            
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() === 'ar' ? 'تم إرسال استطلاع الرأي بنجاح!' : 'Survey submitted successfully!',
                'data' => $survey
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() === 'ar' ? 'حدث خطأ أثناء إرسال الاستطلاع' : 'Error occurred while submitting survey'
            ], 500);
        }
    }
}
