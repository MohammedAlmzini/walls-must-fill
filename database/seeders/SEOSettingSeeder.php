<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SEOSetting;

class SEOSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            // الصفحة الرئيسية - العربية
            [
                'page_key' => 'home',
                'locale' => 'ar',
                'title' => 'معاً لوقف الإبادة ودعم أهل غزة',
                'description' => 'منصة Walls Must لنشر نداءات عاجلة وتدوينات حول القضية الفلسطينية، وجمع تبرعات للحالات الإنسانية في غزة.',
                'keywords' => 'غزة, فلسطين, تبرعات, إغاثة, نداءات عاجلة, دعم إنساني, وقف الإبادة',
                'og_title' => 'Walls Must - معاً لوقف الإبادة ودعم أهل غزة',
                'og_description' => 'منصة Walls Must لنشر نداءات عاجلة وتدوينات حول القضية الفلسطينية، وجمع تبرعات للحالات الإنسانية.',
                'is_active' => true,
            ],
            // الصفحة الرئيسية - الإنجليزية
            [
                'page_key' => 'home',
                'locale' => 'en',
                'title' => 'Together to Stop Genocide and Support Gaza People',
                'description' => 'Walls Must platform for publishing urgent appeals and blog posts about the Palestinian cause, and collecting donations for humanitarian cases in Gaza.',
                'keywords' => 'Gaza, Palestine, donations, relief, urgent appeals, humanitarian support, stop genocide',
                'og_title' => 'Walls Must - Together to Stop Genocide and Support Gaza People',
                'og_description' => 'Walls Must platform for publishing urgent appeals and blog posts about the Palestinian cause, and collecting donations for humanitarian cases.',
                'is_active' => true,
            ],
            // عن المنصة - العربية
            [
                'page_key' => 'about',
                'locale' => 'ar',
                'title' => 'عن منصة Walls Must',
                'description' => 'تعرف على منصة Walls Must ورسالتها في دعم القضية الفلسطينية وأهل غزة، ورؤيتنا لمستقبل أفضل.',
                'keywords' => 'عن المنصة, رسالة, رؤية, غزة, فلسطين, منصة Walls Must',
                'og_title' => 'عن منصة Walls Must - دعم القضية الفلسطينية',
                'og_description' => 'تعرف على منصة Walls Must ورسالتها في دعم القضية الفلسطينية وأهل غزة.',
                'is_active' => true,
            ],
            // عن المنصة - الإنجليزية
            [
                'page_key' => 'about',
                'locale' => 'en',
                'title' => 'About Walls Must Platform',
                'description' => 'Learn about Walls Must platform and its mission in supporting the Palestinian cause and Gaza people, and our vision for a better future.',
                'keywords' => 'about platform, mission, vision, Gaza, Palestine, Walls Must platform',
                'og_title' => 'About Walls Must Platform - Supporting the Palestinian Cause',
                'og_description' => 'Learn about Walls Must platform and its mission in supporting the Palestinian cause and Gaza people.',
                'is_active' => true,
            ],
            // تواصل معنا - العربية
            [
                'page_key' => 'contact',
                'locale' => 'ar',
                'title' => 'تواصل معنا',
                'description' => 'تواصل مع فريق Walls Must لأي استفسارات أو مقترحات حول المنصة، نحن هنا لمساعدتك.',
                'keywords' => 'تواصل, اتصال, استفسارات, دعم, فريق Walls Must',
                'og_title' => 'تواصل معنا - فريق Walls Must',
                'og_description' => 'تواصل مع فريق Walls Must لأي استفسارات أو مقترحات حول المنصة.',
                'is_active' => true,
            ],
            // تواصل معنا - الإنجليزية
            [
                'page_key' => 'contact',
                'locale' => 'en',
                'title' => 'Contact Us',
                'description' => 'Contact Walls Must team for any inquiries or suggestions about the platform, we are here to help you.',
                'keywords' => 'contact, communication, inquiries, support, Walls Must team',
                'og_title' => 'Contact Us - Walls Must Team',
                'og_description' => 'Contact Walls Must team for any inquiries or suggestions about the platform.',
                'is_active' => true,
            ],
            // المدونة - العربية
            [
                'page_key' => 'blog',
                'locale' => 'ar',
                'title' => 'نبض القضية - تدوينات Walls Must',
                'description' => 'تابع آخر التدوينات والمقالات حول القضية الفلسطينية والأحداث في غزة، منصة Walls Must.',
                'keywords' => 'تدوينات, مقالات, غزة, فلسطين, أخبار, منصة Walls Must',
                'og_title' => 'نبض القضية - تدوينات Walls Must',
                'og_description' => 'تابع آخر التدوينات والمقالات حول القضية الفلسطينية والأحداث في غزة.',
                'is_active' => true,
            ],
            // المدونة - الإنجليزية
            [
                'page_key' => 'blog',
                'locale' => 'en',
                'title' => 'Pulse of the Cause - Walls Must Blog',
                'description' => 'Follow the latest blog posts and articles about the Palestinian cause and events in Gaza, Walls Must platform.',
                'keywords' => 'blog posts, articles, Gaza, Palestine, news, Walls Must platform',
                'og_title' => 'Pulse of the Cause - Walls Must Blog',
                'og_description' => 'Follow the latest blog posts and articles about the Palestinian cause and events in Gaza.',
                'is_active' => true,
            ],
            // النداءات العاجلة - العربية
            [
                'page_key' => 'cases',
                'locale' => 'ar',
                'title' => 'نداءات عاجلة - دعم الحالات الإنسانية',
                'description' => 'تصفح النداءات العاجلة للحالات الإنسانية في غزة وساهم في دعمها، منصة Walls Must.',
                'keywords' => 'نداءات عاجلة, تبرعات, إغاثة, غزة, دعم إنساني, منصة Walls Must',
                'og_title' => 'نداءات عاجلة - دعم الحالات الإنسانية في غزة',
                'og_description' => 'تصفح النداءات العاجلة للحالات الإنسانية في غزة وساهم في دعمها.',
                'is_active' => true,
            ],
            // النداءات العاجلة - الإنجليزية
            [
                'page_key' => 'cases',
                'locale' => 'en',
                'title' => 'Urgent Appeals - Support Humanitarian Cases',
                'description' => 'Browse urgent appeals for humanitarian cases in Gaza and contribute to their support, Walls Must platform.',
                'keywords' => 'urgent appeals, donations, relief, Gaza, humanitarian support, Walls Must platform',
                'og_title' => 'Urgent Appeals - Support Humanitarian Cases in Gaza',
                'og_description' => 'Browse urgent appeals for humanitarian cases in Gaza and contribute to their support.',
                'is_active' => true,
            ],
            // الحملة الرئيسية - العربية
            [
                'page_key' => 'main-campaign',
                'locale' => 'ar',
                'title' => 'الحملة الرئيسية - Walls Must',
                'description' => 'انضم إلى الحملة الرئيسية لدعم القضية الفلسطينية وأهل غزة، منصة Walls Must.',
                'keywords' => 'الحملة الرئيسية, دعم, القضية الفلسطينية, غزة, منصة Walls Must',
                'og_title' => 'الحملة الرئيسية - دعم القضية الفلسطينية',
                'og_description' => 'انضم إلى الحملة الرئيسية لدعم القضية الفلسطينية وأهل غزة.',
                'is_active' => true,
            ],
            // الحملة الرئيسية - الإنجليزية
            [
                'page_key' => 'main-campaign',
                'locale' => 'en',
                'title' => 'Main Campaign - Walls Must',
                'description' => 'Join the main campaign to support the Palestinian cause and Gaza people, Walls Must platform.',
                'keywords' => 'main campaign, support, Palestinian cause, Gaza, Walls Must platform',
                'og_title' => 'Main Campaign - Support the Palestinian Cause',
                'og_description' => 'Join the main campaign to support the Palestinian cause and Gaza people.',
                'is_active' => true,
            ],
        ];

        foreach ($defaultSettings as $setting) {
            SEOSetting::updateOrCreate(
                ['page_key' => $setting['page_key'], 'locale' => $setting['locale']],
                $setting
            );
        }
    }
}
