<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\AidCase;
use App\Models\MainCampaign;

class HomeController extends Controller
{
    public function index()
    {
        $casesCount = AidCase::count();
        $totalDonations = AidCase::sum('collected_amount');
        $completedActual = AidCase::where('is_completed', true)->count();
        $completedDisplayed = $completedActual + 100; // إضافة 100 كما طلبت

        $latestPosts = Post::where('is_published', true)->latest('published_at')->take(6)->get();
        $latestCases = AidCase::latest()->take(6)->get();

        // الحملة الرئيسية لأيتام غزة
        $mainCampaign = MainCampaign::where('is_active', true)->first();
        
        if (!$mainCampaign) {
            // بيانات افتراضية إذا لم توجد حملة
            $mainCampaign = (object) [
                'title' => 'حملة إغاثة أيتام غزة',
                'subtitle' => 'كن جزءاً من الأمل - ادعم أيتام غزة في محنتهم',
                'description' => 'أطفال فقدوا كل شيء.. آباءهم، منازلهم، أحلامهم. ساعدنا في إعادة الأمل إلى قلوبهم الصغيرة وتوفير الطعام والدواء والمأوى الآمن لهم.',
                'goal_amount' => 500000,
                'collected_amount' => 147500,
                'supporters_count' => 2847,
                'days_left' => 45,
                'percentage' => 29.5,
                'urgent_needs' => [
                    'طعام ومياه نظيفة',
                    'أدوية ورعاية طبية',
                    'مأوى آمن ودافئ',
                    'ملابس وبطانيات',
                    'مستلزمات تعليمية'
                ],
                'paypal_qr_code' => null,
                'whatsapp_number' => '+970599123456'
            ];
        }

        return view('home', compact(
            'casesCount', 'totalDonations', 'completedDisplayed',
            'latestPosts', 'latestCases', 'mainCampaign'
        ));
    }
}