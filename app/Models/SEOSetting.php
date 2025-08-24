<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEOSetting extends Model
{
    use HasFactory;
    
    protected $table = 'seo_settings';

    protected $fillable = [
        'page_key',
        'locale',
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'structured_data',
        'is_active'
    ];

    protected $casts = [
        'structured_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    public function scopeByPage($query, $pageKey)
    {
        return $query->where('page_key', $pageKey);
    }

    public function getFullTitleAttribute()
    {
        $siteName = config('app.site_name', 'Walls Must Fall');
        return $this->title . ' - ' . $siteName;
    }

    public function getOgTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getOgDescriptionAttribute($value)
    {
        return $value ?: $this->description;
    }

    public function getTwitterTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getTwitterDescriptionAttribute($value)
    {
        return $value ?: $this->description;
    }
}
