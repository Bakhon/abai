<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalStructureBkns extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
