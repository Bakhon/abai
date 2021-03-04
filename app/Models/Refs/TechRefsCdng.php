<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechRefsCdng extends Model
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
        return $this->belongsTo('App\Models\Refs\TechRefsNgdu', 'ngdu_id');
    }
}
