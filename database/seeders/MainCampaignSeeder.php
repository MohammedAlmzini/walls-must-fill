<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MainCampaign;

class MainCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MainCampaign::create([
            'title' => 'حملة إغاثة أيتام غزة',
            'subtitle' => 'كن جزءاً من الأمل - ادعم أيتام غزة في محنتهم',
            'description' => 'أطفال فقدوا كل شيء.. آباءهم، منازلهم، أحلامهم. ساعدنا في إعادة الأمل إلى قلوبهم الصغيرة وتوفير الطعام والدواء والمأوى الآمن لهم.',
            'goal_amount' => 500000,
            'collected_amount' => 147500,
            'supporters_count' => 2847,
            'urgent_needs' => [
                'طعام ومياه نظيفة',
                'أدوية ورعاية طبية',
                'مأوى آمن ودافئ',
                'ملابس وبطانيات',
                'مستلزمات تعليمية'
            ],
            'paypal_qr_code' => 'storage/qr/paypal-donation-qr.png',
            'whatsapp_number' => '+970599123456',
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(45),
        ]);
    }
}
