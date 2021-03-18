<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalDataLog extends Model
{
    protected $fillable = [
        'author_id'
    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}