<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scientist extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'hometown',
        'ethnicity',
        'highest_degree',
        'year_awarded_degree',
        'country_awarded_degree',
        'scientific_title',
        'year_title_appointment',
        'position',
        'workplace',
        'address',
        'phone_office',
        'phone_home',
        'phone_mobile',
        'fax',
        'citizen_id',
        'date_issue',
        'place_issue',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function publishedPapers()
    {
        return $this->hasMany(PublishedPaper:: class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function workExps()
    {
        return $this->hasMany(WorkExp::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
