<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class EconomicDataLog extends Model
{
    protected $fillable = [
        'author_id', 'type_id', 'name', 'is_processed'
    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}