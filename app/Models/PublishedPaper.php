<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublishedPaper extends Model
{
    protected $fillable = [
        'scientist_id', 
        'url', 
        'doi', 
        'authors', 
        'title', 
        'publication_date', 
        'issn', 
        'publisher'
    ];

    public function scientist()
    {
        return $this->belongsTo(Scientist:: class);
    }
}
