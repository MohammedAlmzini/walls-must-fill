<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AidCase extends Model
{
    protected $fillable = [
        'title','slug','description','cover_image_path','qr_image_path',
        'video_url','whatsapp_number','goal_amount','collected_amount','is_completed'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'goal_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
    ];

    protected static function booted() {
        static::creating(function ($case) {
            if (empty($case->slug)) {
                $case->slug = Str::slug($case->title) . '-' . Str::random(6);
            }
        });
    }

    public function images() {
        return $this->hasMany(CaseImage::class);
    }

    public function getWhatsappLinkAttribute(): ?string
    {
        if (!$this->whatsapp_number) return null;
        $num = preg_replace('/\D+/', '', $this->whatsapp_number);
        $msg = urlencode("السلام عليكم، أودّ التبرع/الدعم لحالة: {$this->title}");
        return "https://wa.me/{$num}?text={$msg}";
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $url = trim((string) $this->video_url);
        if ($url === '') return null;

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