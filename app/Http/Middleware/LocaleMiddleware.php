<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // First, check if there's a saved locale in session
        $savedLocale = Session::get('locale');
        
        // If no session locale, check cookies
        if (!$savedLocale) {
            $savedLocale = $request->cookie('locale');
        }
        
        // Get locale from URL segment
        $urlLocale = $request->segment(1);
        
        // Determine which locale to use
        $locale = null;
        
        // If there's a valid locale in URL, use it and update session and cookie
        if (in_array($urlLocale, ['en', 'ar'])) {
            $locale = $urlLocale;
            Session::put('locale', $locale);
            Cookie::queue('locale', $locale, 60 * 24 * 30); // 30 days
        }
        // If no valid URL locale but there's a saved locale in session/cookie, use it
        elseif ($savedLocale && in_array($savedLocale, ['en', 'ar'])) {
            $locale = $savedLocale;
            // Ensure session is updated
            Session::put('locale', $locale);
        }
        // Default to English if no valid locale found
        else {
            $locale = 'en';
            Session::put('locale', $locale);
            Cookie::queue('locale', $locale, 60 * 24 * 30); // 30 days
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        return $next($request);
    }
}