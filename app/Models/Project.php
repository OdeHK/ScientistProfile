<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'scientist_id',
        'title',
        'level',
        'start_year',
        'end_year',
        'position'
    ];

    public function scientist()
    {
        return $this->belongsTo(Scientist::class);
    }
}
