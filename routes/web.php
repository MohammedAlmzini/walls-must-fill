<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PublicAidCaseController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminAidCaseController;
use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminMainCampaignController;
use App\Http\Controllers\Admin\AdminSEOController;
use App\Http\Controllers\MainCampaignController;
use App\Http\Controllers\SEOController;
use App\Services\SEOService;

// تغيير اللغة
Route::get('/locale/{locale}', function ($locale, Request $request) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

// تغيير اللغة - route بديل
Route::get('/language/{locale}', function ($locale, Request $request) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');

// Redirect root to English locale
Route::get('/', function () {
    return redirect('/en');
});

// English Routes
Route::prefix('en')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('en.home');
    Route::get('/about', function () {
        return view('about');
    })->name('en.about');
    Route::get('/contact', [ContactController::class, 'show'])->name('en.contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('en.contact.submit');
    Route::get('/cases', [PublicAidCaseController::class, 'index'])->name('en.cases.index');
    Route::get('/cases/{case}', [PublicAidCaseController::class, 'show'])->name('en.cases.show');
    Route::get('/posts', [PublicPostController::class, 'index'])->name('en.posts.index');
    Route::get('/posts/{post}', [PublicPostController::class, 'show'])->name('en.posts.show');
    Route::get('/main-campaign', [MainCampaignController::class, 'show'])->name('en.main-campaign');
    Route::get('/support', function () {return redirect('/en/cases');})->name('en.support');
    
    // Blog Routes - إضافة جديدة
    Route::get('/blog', [PublicPostController::class, 'index'])->name('en.blog.index');
});

// Arabic Routes
Route::prefix('ar')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('ar.home');
    Route::get('/about', function () {
        return view('about');
    })->name('ar.about');
    Route::get('/contact', [ContactController::class, 'show'])->name('ar.contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('ar.contact.submit');
    Route::get('/cases', [PublicAidCaseController::class, 'index'])->name('ar.cases.index');
    Route::get('/cases/{case}', [PublicAidCaseController::class, 'show'])->name('ar.cases.show');
    Route::get('/posts', [PublicPostController::class, 'index'])->name('ar.posts.index');
    Route::get('/posts/{post}', [PublicPostController::class, 'show'])->name('ar.posts.show');
    Route::get('/main-campaign', [MainCampaignController::class, 'show'])->name('ar.main-campaign');
    Route::get('/support', function () {return redirect('/ar/cases');})->name('ar.support');
    
    // Blog Routes - إضافة جديدة
    Route::get('/blog', [PublicPostController::class, 'index'])->name('ar.blog.index');
});

// Fallback routes (without locale prefix) - redirect to English
Route::get('/home', function () {
    return redirect('/en');
})->name('home');

// Public Routes - إضافات جديدة
Route::get('/blog', [PublicPostController::class, 'index'])->name('blog.index');
Route::get('/posts/{slug}', [PublicPostController::class, 'show'])->name('posts.show');

Route::get('/about', function () {
    return redirect('/en/about');
})->name('about');

// Static Pages with SEO - إضافة جديدة
Route::view('/about-static', 'about')->name('about.static');

Route::get('/contact', function () {
    return redirect('/en/contact');
})->name('contact');

Route::get('/cases', function () {
    return redirect('/en/cases');
})->name('cases.index');

Route::get('/cases/{case}', function ($case) {
    return redirect('/en/cases/' . $case);
})->name('cases.show');

Route::get('/posts', function () {
    return redirect('/en/posts');
})->name('posts.index');

Route::get('/posts/{post}', function ($post) {
    return redirect('/en/posts/' . $post);
})->name('posts.show');

// Main Campaign - إضافة جديدة
Route::get('/main-campaign', [MainCampaignController::class, 'show'])->name('main-campaign.show');

// SEO Routes - إضافات جديدة
Route::get('/sitemap.xml', [SEOController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SEOController::class, 'robots'])->name('robots');

// مسار خاص لتسجيل دخول الأدمن (لا يظهر في الهيدر)
Route::get('/admin-portal-walls-must/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin-portal-walls-must/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin-portal-walls-must/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// لوحة التحكم - محمية بميدل وير
Route::middleware(['admin.auth'])->prefix('/admin-portal-walls-must')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // تدوينات
    Route::resource('posts', AdminPostController::class);

    // الحالات
    Route::resource('cases', AdminAidCaseController::class);

    // رسائل التواصل
    Route::get('/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
    Route::post('/messages/{message}/toggle', [AdminContactMessageController::class, 'toggleRead'])->name('messages.toggle');
    
    // Messages Management - إضافة جديدة
    Route::patch('/messages/{message}/toggle-read', [AdminContactMessageController::class, 'toggleRead'])->name('messages.toggle-read');

    // الحملة الرئيسية
    Route::get('/main-campaign', [AdminMainCampaignController::class, 'index'])->name('main-campaign.index');
    Route::get('/main-campaign/edit', [AdminMainCampaignController::class, 'edit'])->name('main-campaign.edit');
    Route::put('/main-campaign', [AdminMainCampaignController::class, 'update'])->name('main-campaign.update');

    // إدارة SEO
    Route::get('/seo', [AdminSEOController::class, 'index'])->name('seo.index');
    Route::get('/seo/create', [AdminSEOController::class, 'create'])->name('seo.create');
    Route::post('/seo', [AdminSEOController::class, 'store'])->name('seo.store');
    Route::get('/seo/{id}/edit', [AdminSEOController::class, 'edit'])->name('seo.edit');
    Route::put('/seo/{id}', [AdminSEOController::class, 'update'])->name('seo.update');
    Route::delete('/seo/{id}', [AdminSEOController::class, 'destroy'])->name('seo.destroy');
    Route::post('/seo/{id}/toggle', [AdminSEOController::class, 'toggleStatus'])->name('seo.toggle');
    Route::post('/seo/bulk-actions', [AdminSEOController::class, 'bulkActions'])->name('seo.bulk-actions');
    Route::get('/seo/{pageKey}/preview/{locale?}', [AdminSEOController::class, 'preview'])->name('seo.preview');
});

// Admin Routes - إضافات جديدة (مسارات مبسطة)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login.simple');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.simple.submit');
    
    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout.simple');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard.simple');
        
        // Posts Management
        Route::resource('posts', AdminPostController::class, ['as' => 'simple']);
        
        // Cases Management  
        Route::resource('cases', AdminAidCaseController::class, ['as' => 'simple']);
        
        // Messages Management
        Route::resource('messages', AdminContactMessageController::class, ['as' => 'simple'])->only(['index', 'show', 'destroy']);
        
        // Main Campaign Management
        Route::get('/main-campaign', [AdminMainCampaignController::class, 'index'])->name('main-campaign.simple.index');
        Route::get('/main-campaign/edit', [AdminMainCampaignController::class, 'edit'])->name('main-campaign.simple.edit');
        Route::put('/main-campaign', [AdminMainCampaignController::class, 'update'])->name('main-campaign.simple.update');
    });
});

// API routes (keep existing)
Route::prefix('api')->group(function () {
    // Add your API routes here
});