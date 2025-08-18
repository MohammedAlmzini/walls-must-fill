<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get locale from URL segment
        $locale = $request->segment(1);
        
        // Check if locale is valid
        if (in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Default to English if no valid locale
            App::setLocale('en');
            Session::put('locale', 'en');
        }
        
        return $next($request);
    }
}