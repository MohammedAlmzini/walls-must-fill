<?php

namespace App\Services;

use App\Models\SEOSetting;
use Carbon\Carbon;

class SEOService
{
    public static function getPageMeta($page, $data = [], $locale = 'ar')
    {
        // محاولة الحصول من قاعدة البيانات أولاً
        $seoSetting = SEOSetting::active()
            ->byPage($page)
            ->byLocale($locale)
            ->first();

        $siteName = config('app.site_name', 'Walls Must Fall');
        $baseDescription = 'منصة Walls Must لنشر نداءات عاجلة وتدوينات حول القضية الفلسطينية، وجمع تبرعات للحالات الإنسانية.';
        
        $meta = [
            'site_name' => $siteName,
            'url' => request()->url(),
            'type' => 'website',
            'locale' => $locale,
            'image' => asset('images/og-default.jpg'),
        ];

        if ($seoSetting) {
            // استخدام البيانات من قاعدة البيانات
            $meta['title'] = $seoSetting->full_title;
            $meta['description'] = $seoSetting->description;
            $meta['keywords'] = $seoSetting->keywords;
            $meta['og_title'] = $seoSetting->og_title;
            $meta['og_description'] = $seoSetting->og_description;
            $meta['og_image'] = $seoSetting->og_image ?: $meta['image'];
            $meta['twitter_title'] = $seoSetting->twitter_title;
            $meta['twitter_description'] = $seoSetting->twitter_description;
            $meta['twitter_image'] = $seoSetting->twitter_image ?: $meta['image'];
            $meta['structured_data'] = $seoSetting->structured_data;
        } else {
            // استخدام القيم الافتراضية
            switch ($page) {
                case 'home':
                    $meta['title'] = $siteName . ' - معاً لوقف الإبادة ودعم أهل غزة';
                    $meta['description'] = $baseDescription;
                    $meta['keywords'] = 'غزة, فلسطين, تبرعات, إغاثة, نداءات عاجلة, دعم إنساني';
                    break;

                case 'post':
                    $post = $data['post'] ?? null;
                    if ($post) {
                        $meta['title'] = $post->title . ' - ' . $siteName;
                        $meta['description'] = $post->meta_description ?: ($post->excerpt ?: substr(strip_tags($post->body), 0, 160));
                        $meta['keywords'] = 'تدوينة, ' . $post->title . ', غزة, فلسطين';
                        $meta['type'] = 'article';
                        $meta['image'] = $post->image_path ? asset('storage/' . $post->image_path) : $meta['image'];
                        $meta['published_time'] = $post->published_at ? Carbon::parse($post->published_at)->toISOString() : null;
                        $meta['author'] = $post->author?->name ?? $siteName;
                    }
                    break;

                case 'case':
                    $case = $data['case'] ?? null;
                    if ($case) {
                        $meta['title'] = $case->title . ' - نداء عاجل - ' . $siteName;
                        $meta['description'] = substr(strip_tags($case->description), 0, 160);
                        $meta['keywords'] = 'نداء عاجل, ' . $case->title . ', تبرع, غزة, إغاثة';
                        $meta['image'] = $case->cover_image_path ? asset('storage/' . $case->cover_image_path) : $meta['image'];
                    }
                    break;

                case 'blog':
                    $meta['title'] = 'نبض القضية - تدوينات ' . $siteName;
                    $meta['description'] = 'تابع آخر التدوينات والمقالات حول القضية الفلسطينية والأحداث في غزة.';
                    $meta['keywords'] = 'تدوينات, مقالات, غزة, فلسطين, أخبار';
                    break;

                case 'cases':
                    $meta['title'] = 'نداءات عاجلة - ' . $siteName;
                    $meta['description'] = 'تصفح النداءات العاجلة للحالات الإنسانية في غزة وساهم في دعمها.';
                    $meta['keywords'] = 'نداءات عاجلة, تبرعات, إغاثة, غزة, دعم إنساني';
                    break;

                case 'about':
                    $meta['title'] = 'عن المنصة - ' . $siteName;
                    $meta['description'] = 'تعرف على منصة Walls Must ورسالتها في دعم القضية الفلسطينية وأهل غزة.';
                    $meta['keywords'] = 'عن المنصة, رسالة, رؤية, غزة, فلسطين';
                    break;

                case 'contact':
                    $meta['title'] = 'تواصل معنا - ' . $siteName;
                    $meta['description'] = 'تواصل مع فريق ' . $siteName . ' لأي استفسارات أو مقترحات حول المنصة.';
                    $meta['keywords'] = 'تواصل, اتصال, استفسارات, دعم';
                    break;

                default:
                    $meta['title'] = $siteName;
                    $meta['description'] = $baseDescription;
                    $meta['keywords'] = 'غزة, فلسطين, تبرعات, إغاثة';
            }
        }

        return $meta;
    }

    public static function generateStructuredData($type, $data = [])
    {
        $baseUrl = url('/');
        
        switch ($type) {
            case 'organization':
                return [
                    '@context' => 'https://schema.org',
                    '@type' => 'Organization',
                    'name' => 'Walls Must',
                    'description' => 'منصة لدعم القضية الفلسطينية وإيصال نداءات الإغاثة من غزة',
                    'url' => $baseUrl,
                    'logo' => asset('images/logo.png'),
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'contactType' => 'customer support',
                        'email' => 'support@wallsmust.org'
                    ]
                ];

            case 'article':
                $post = $data['post'] ?? null;
                if ($post) {
                    return [
                        '@context' => 'https://schema.org',
                        '@type' => 'Article',
                        'headline' => $post->title,
                        'description' => $post->excerpt ?: substr(strip_tags($post->body), 0, 160),
                        'author' => [
                            '@type' => 'Person',
                            'name' => $post->author?->name ?? 'Walls Must'
                        ],
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => 'Walls Must',
                            'logo' => [
                                '@type' => 'ImageObject',
                                'url' => asset('images/logo.png')
                            ]
                        ],
                        'datePublished' => $post->published_at ? Carbon::parse($post->published_at)->toISOString() : null,
                        'dateModified' => $post->updated_at ? Carbon::parse($post->updated_at)->toISOString() : null,
                        'image' => $post->image_path ? asset('storage/' . $post->image_path) : asset('images/default-post.jpg'),
                        'url' => route('posts.show', $post->slug)
                    ];
                }
                break;

            case 'fundraising':
                $case = $data['case'] ?? null;
                if ($case) {
                    return [
                        '@context' => 'https://schema.org',
                        '@type' => 'Event',
                        'name' => $case->title,
                        'description' => substr(strip_tags($case->description), 0, 300),
                        'image' => $case->cover_image_path ? asset('storage/' . $case->cover_image_path) : asset('images/default-case.jpg'),
                        'url' => route('cases.show', $case->slug),
                        'organizer' => [
                            '@type' => 'Organization',
                            'name' => 'Walls Must'
                        ]
                    ];
                }
                break;
        }

        return null;
    }

    public static function getAvailablePages()
    {
        return [
            'home' => 'الصفحة الرئيسية',
            'about' => 'عن المنصة',
            'contact' => 'تواصل معنا',
            'blog' => 'المدونة',
            'cases' => 'النداءات العاجلة',
            'main-campaign' => 'الحملة الرئيسية'
        ];
    }

    public static function getAvailableLocales()
    {
        return [
            'ar' => 'العربية',
            'en' => 'English'
        ];
    }
}