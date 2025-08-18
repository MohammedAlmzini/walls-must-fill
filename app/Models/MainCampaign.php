<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'goal_amount',
        'collected_amount',
        'supporters_count',
        'days_left',
        'urgent_needs',
        'paypal_qr_code',
        'whatsapp_number',
        'is_active',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'urgent_needs' => 'array',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'goal_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2'
    ];

    public function getPercentageAttribute()
    {
        if ($this->goal_amount <= 0) {
            return 0;
        }
        
        $percentage = ($this->collected_amount / $this->goal_amount) * 100;
        return min(round($percentage, 1), 100);
    }

    public function getRemainingAmountAttribute()
    {
        return max(0, $this->goal_amount - $this->collected_amount);
    }

    public function getDaysLeftAttribute()
    {
        if (!$this->end_date) {
            return 0;
        }
        
        $days = now()->diffInDays($this->end_date, false);
        return max(0, $days);
    }
}
