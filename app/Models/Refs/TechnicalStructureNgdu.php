<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalStructureNgdu extends Model
{
    protected $fillable = [
        'name', 'field_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function field()
    {
        return $this->belongsTo('App\Models\Refs\TechnicalStructureField', 'field_id');
    }
}
