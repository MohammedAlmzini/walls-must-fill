<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;
use App\Models\AidCase;
use App\Models\MainCampaign;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@wallsmust.org'],
            [
                'name' => 'Site Admin',
                'password' => Hash::make('StrongPassword123!'),
                'is_admin' => true
            ]
        );

        Post::create([
            'title' => 'نداء إنساني من غزة',
            'excerpt' => 'رسالة موجعة من الداخل...',
            'body' => '<p>تغطية لأوضاع إنسانية عاجلة...</p>',
            'is_published' => true,
            'published_at' => now(),
            'user_id' => $admin->id,
        ]);

        AidCase::create([
            'title' => 'علاج طفل مصاب بحاجة دواء عاجل',
            'description' => 'الطفل يحتاج إلى دواء غير متوفر داخل القطاع...',
            'whatsapp_number' => '+970599000000',
            'goal_amount' => 3000,
            'collected_amount' => 750,
            'is_completed' => false,
        ]);

        // إنشاء الحملة الرئيسية
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