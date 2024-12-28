<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExp extends Model
{
    protected $fillable = [
        'scientist_id',
        'start_date',
        'end_date',
        'institution',
        'position',
    ];

    public function scientist()
    {
        return $this->belongsTo(Scientist::class);
    }
}
