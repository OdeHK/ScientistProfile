<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageSkill extends Model
{
    protected $fillable = [];

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
