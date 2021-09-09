<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalStructureCdng extends Model
{
    protected $fillable = [
        'name', 'ngdu_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function ngdu()
    {
        return $this->belongsTo(TechnicalStructureNgdu::class, 'ngdu_id');
    }

    public function gus()
    {
        return $this->hasMany(TechnicalStructureGu::class, 'cdng_id');
    }
}
