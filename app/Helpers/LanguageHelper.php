<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LanguageHelper
{
    /**
     * Get current locale
     */
    public static function getCurrentLocale()
    {
        return App::getLocale();
    }

    /**
     * Get saved locale from session or cookie
     */
    public static function getSavedLocale()
    {
        // Check session first
        $locale = Session::get('locale');
        
        // If no session, check cookie
        if (!$locale) {
            $locale = request()->cookie('locale');
        }
        
        // Validate locale
        if (in_array($locale, ['en', 'ar'])) {
            return $locale;
        }
        
        return null;
    }

    /**
     * Check if current locale is Arabic
     */
    public static function isArabic()
    {
        return App::getLocale() === 'ar';
    }

    /**
     * Check if current locale is English
     */
    public static function isEnglish()
    {
        return App::getLocale() === 'en';
    }

    /**
     * Get text direction
     */
    public static function getTextDirection()
    {
        return self::isArabic() ? 'rtl' : 'ltr';
    }

    /**
     * Get opposite locale
     */
    public static function getOppositeLocale()
    {
        return self::isArabic() ? 'en' : 'ar';
    }

    /**
     * Get locale name
     */
    public static function getLocaleName($locale = null)
    {
        $locale = $locale ?: self::getCurrentLocale();
        
        return $locale === 'ar' ? 'العربية' : 'English';
    }

    /**
     * Get localized route
     */
    public static function getLocalizedRoute($name, $parameters = [], $absolute = true)
    {
        $locale = self::getCurrentLocale();
        $routeName = $locale . '.' . $name;
        
        if (Route::has($routeName)) {
            return route($routeName, $parameters, $absolute);
        }
        
        // If the name already has locale prefix, try to use it directly
        if (strpos($name, $locale . '.') === 0) {
            if (Route::has($name)) {
                return route($name, $parameters, $absolute);
            }
        }
        
        // Fallback to original route
        return route($name, $parameters, $absolute);
    }

    /**
     * Get localized URL
     */
    public static function getLocalizedUrl($path = '')
    {
        $locale = self::getCurrentLocale();
        return url($locale . '/' . ltrim($path, '/'));
    }

    /**
     * Get localized URL for current path
     */
    public static function getLocalizedCurrentUrl()
    {
        $locale = self::getCurrentLocale();
        $currentPath = request()->path();
        $pathWithoutLocale = preg_replace('/^(en|ar)\/?/', '', $currentPath);
        return url($locale . '/' . ltrim($pathWithoutLocale, '/'));
    }

    /**
     * Get language switcher data
     */
    public static function getLanguageSwitcherData()
    {
        $currentRoute = Route::current();
        $currentLocale = self::getCurrentLocale();
        $oppositeLocale = self::getOppositeLocale();
        
        // Remove locale from route parameters
        $parameters = $currentRoute->parameters();
        unset($parameters['locale']);
        
        // Build route name without locale
        $routeName = $currentRoute->getName();
        if (strpos($routeName, $currentLocale . '.') === 0) {
            $routeName = substr($routeName, 3); // Remove 'en.' or 'ar.'
        }
        
        return [
            'current_locale' => $currentLocale,
            'opposite_locale' => $oppositeLocale,
            'current_locale_name' => self::getLocaleName($currentLocale),
            'opposite_locale_name' => self::getLocaleName($oppositeLocale),
            'current_url' => url()->current(),
            'opposite_url' => self::getLocalizedCurrentUrl(),
        ];
    }
}

