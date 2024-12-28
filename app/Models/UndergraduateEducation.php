<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UndergraduateEducation extends Model
{
    protected $table = 'undergraduate_educations';
    protected $fillable = [
        'education_id',
        'training_system',
        'training_country',
        'graduation_year',
    ];

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
