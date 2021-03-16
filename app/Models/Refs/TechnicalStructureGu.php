<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalStructureGu extends Model
{
    protected $fillable = [
        'name', 'cdng_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function cdng()
    {
        return $this->belongsTo('App\Models\Refs\TechnicalStructureCdng', 'cdng_id');
    }
}
