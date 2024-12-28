<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';
    protected $fillable = [
        'scientist_id',
        'institution',
        'field_of_study',
        'graduation_year',
        'type'
    ];

    public function scientist()
    {
        return $this->belongsTo(Scientist::class);
    }

    public function languageSkill()
    {
        return $this->hasMany(LanguageSkill::class);
    }

    public function undergraduate()
    {
        return $this->hasMany(UndergraduateEducation::class);
    }

    public function postgraduate()
    {
        return $this->hasMany(PostgraduateEducation::class);
    }
}
