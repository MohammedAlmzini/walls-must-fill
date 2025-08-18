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
use App\Http\Controllers\MainCampaignController;


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
});

// Fallback routes (without locale prefix) - redirect to English
Route::get('/home', function () {
    return redirect('/en');
})->name('home');

Route::get('/about', function () {
    return redirect('/en/about');
})->name('about');

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

    // الحملة الرئيسية
    Route::get('/main-campaign', [AdminMainCampaignController::class, 'index'])->name('main-campaign.index');
    Route::get('/main-campaign/edit', [AdminMainCampaignController::class, 'edit'])->name('main-campaign.edit');
    Route::put('/main-campaign', [AdminMainCampaignController::class, 'update'])->name('main-campaign.update');
});

// API routes (keep existing)
Route::prefix('api')->group(function () {
    // Add your API routes here
});