<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalStructureCompany extends Model
{
    protected $fillable = [
        'name', 'short_name', 'tbd_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
