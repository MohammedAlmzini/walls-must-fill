<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipCampaignSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'whatsapp_number',
        'email',
        'age',
        'question1_answer',
        'question2_answer',
        'question3_answer',
        'question4_answer',
        'question5_answer',
    ];

    protected $casts = [
        'age' => 'integer',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
