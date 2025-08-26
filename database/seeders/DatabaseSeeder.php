<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;
use App\Models\AidCase;
use App\Models\MainCampaign;
use App\Models\SEOSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            MainCampaignSeeder::class,
            SEOSettingSeeder::class,
            ShipCampaignSurveySeeder::class,
        ]);
    }
}