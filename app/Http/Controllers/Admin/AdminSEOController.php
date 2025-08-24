<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SEOSetting;
use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSEOController extends Controller
{
    public function index()
    {
        $seoSettings = SEOSetting::orderBy('page_key')
            ->orderBy('locale')
            ->get()
            ->groupBy('page_key');

        $availablePages = SEOService::getAvailablePages();
        $availableLocales = SEOService::getAvailableLocales();

        return view('admin.seo.index', compact('seoSettings', 'availablePages', 'availableLocales'));
    }

    public function create()
    {
        $availablePages = SEOService::getAvailablePages();
        $availableLocales = SEOService::getAvailableLocales();

        return view('admin.seo.create', compact('availablePages', 'availableLocales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_key' => 'required|string|max:255',
            'locale' => 'required|string|max:5',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // التحقق من عدم وجود إعدادات مكررة
        $existingSetting = SEOSetting::where('page_key', $request->page_key)
            ->where('locale', $request->locale)
            ->first();

        if ($existingSetting) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['page_key' => 'يوجد إعدادات SEO لهذه الصفحة واللغة بالفعل']);
        }

        $data = $request->except(['og_image', 'twitter_image', 'is_active']);
        $data['is_active'] = $request->has('is_active');

        // معالجة الصور
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadImage($request->file('og_image'), 'og');
        }

        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $this->uploadImage($request->file('twitter_image'), 'twitter');
        }

        SEOSetting::create($data);

        return redirect()->route('admin.seo.index')
            ->with('success', 'تم إنشاء إعدادات SEO بنجاح');
    }

    public function edit($id)
    {
        $seoSetting = SEOSetting::findOrFail($id);
        
        $availablePages = SEOService::getAvailablePages();
        $availableLocales = SEOService::getAvailableLocales();

        return view('admin.seo.edit', compact('seoSetting', 'availablePages', 'availableLocales'));
    }

    public function update(Request $request, $id)
    {
        $seoSetting = SEOSetting::findOrFail($id);
        
        $request->validate([
            'page_key' => 'required|string|max:255',
            'locale' => 'required|string|max:5',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // التحقق من عدم وجود إعدادات مكررة (باستثناء السجل الحالي)
        $existingSetting = SEOSetting::where('page_key', $request->page_key)
            ->where('locale', $request->locale)
            ->where('id', '!=', $seoSetting->id)
            ->first();

        if ($existingSetting) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['page_key' => 'يوجد إعدادات SEO لهذه الصفحة واللغة بالفعل']);
        }

        $data = $request->except(['og_image', 'twitter_image', 'is_active']);
        $data['is_active'] = $request->has('is_active');

        // معالجة الصور
        if ($request->hasFile('og_image')) {
            // حذف الصورة القديمة
            if ($seoSetting->og_image) {
                Storage::delete('public/' . $seoSetting->og_image);
            }
            $data['og_image'] = $this->uploadImage($request->file('og_image'), 'og');
        }

        if ($request->hasFile('twitter_image')) {
            // حذف الصورة القديمة
            if ($seoSetting->twitter_image) {
                Storage::delete('public/' . $seoSetting->twitter_image);
            }
            $data['twitter_image'] = $this->uploadImage($request->file('twitter_image'), 'twitter');
        }

        $seoSetting->update($data);

        return redirect()->route('admin.seo.index')
            ->with('success', 'تم تحديث إعدادات SEO بنجاح');
    }

    public function destroy($id)
    {
        $seoSetting = SEOSetting::findOrFail($id);
        
        // حذف الصور
        if ($seoSetting->og_image) {
            Storage::delete('public/' . $seoSetting->og_image);
        }
        if ($seoSetting->twitter_image) {
            Storage::delete('public/' . $seoSetting->twitter_image);
        }

        $seoSetting->delete();

        return redirect()->route('admin.seo.index')
            ->with('success', 'تم حذف إعدادات SEO بنجاح');
    }

    public function toggleStatus($id)
    {
        $seoSetting = SEOSetting::findOrFail($id);
        
        $seoSetting->update(['is_active' => !$seoSetting->is_active]);

        $status = $seoSetting->is_active ? 'مفعل' : 'معطل';
        return redirect()->route('admin.seo.index')
            ->with('success', "تم $status إعدادات SEO بنجاح");
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'seo_settings' => 'required|array',
            'seo_settings.*' => 'exists:seo_settings,id'
        ]);

        $seoSettings = SEOSetting::whereIn('id', $request->seo_settings);

        switch ($request->action) {
            case 'activate':
                $seoSettings->update(['is_active' => true]);
                $message = 'تم تفعيل إعدادات SEO المحددة';
                break;
            case 'deactivate':
                $seoSettings->update(['is_active' => false]);
                $message = 'تم تعطيل إعدادات SEO المحددة';
                break;
            case 'delete':
                // حذف الصور أولاً
                $seoSettings->get()->each(function ($setting) {
                    if ($setting->og_image) {
                        Storage::delete('public/' . $setting->og_image);
                    }
                    if ($setting->twitter_image) {
                        Storage::delete('public/' . $setting->twitter_image);
                    }
                });
                $seoSettings->delete();
                $message = 'تم حذف إعدادات SEO المحددة';
                break;
        }

        return redirect()->route('admin.seo.index')
            ->with('success', $message);
    }

    private function uploadImage($image, $type)
    {
        $filename = $type . '_' . time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('seo-images', $filename, 'public');
        return $path;
    }

    public function preview($pageKey, $locale = 'ar')
    {
        $seoSetting = SEOSetting::where('page_key', $pageKey)
            ->where('locale', $locale)
            ->first();

        if (!$seoSetting) {
            return redirect()->route('admin.seo.index')
                ->with('error', 'لم يتم العثور على إعدادات SEO لهذه الصفحة');
        }

        $meta = SEOService::getPageMeta($pageKey, [], $locale);
        
        return view('admin.seo.preview', compact('seoSetting', 'meta', 'pageKey', 'locale'));
    }
}
