<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title','slug','excerpt','body','image_path','youtube_url','meta_description',
        'is_published','published_at','user_id'
    ];

    protected static function booted() {
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . Str::random(6);
            }
        });
        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . Str::random(6);
            }
        });
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $url = trim((string) $this->youtube_url);
        if ($url === '') return null;

        // إن كان بالفعل embed
        if (preg_match('~/(embed|e)/([a-zA-Z0-9_-]{6,})~', $url, $m)) {
            $id = $m[2];
        } elseif (preg_match('~youtu\.be/([a-zA-Z0-9_-]{6,})~', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~youtube\.com/watch\?v=([a-zA-Z0-9_-]{6,})~', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~youtube\.com/shorts/([a-zA-Z0-9_-]{6,})~', $url, $m)) {
            $id = $m[1];
        } else {
            return null;
        }

        return "https://www.youtube-nocookie.com/embed/{$id}?rel=0&modestbranding=1&color=white";
    }
}