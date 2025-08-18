<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseImage extends Model
{
    protected $fillable = ['aid_case_id','image_path'];

    public function aidCase() {
        return $this->belongsTo(AidCase::class);
    }
}