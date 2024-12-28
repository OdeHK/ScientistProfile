<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostGraduateEducation extends Model
{
    protected $table = 'postgraduate_educations';
    protected $fillable = [
        'education_id',
        'level',
        'thesis_title',
        'graduation_year',
    ];

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
