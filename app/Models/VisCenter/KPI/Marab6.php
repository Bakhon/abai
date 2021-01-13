<?php

namespace App\Models\VisCenter\KPI;

use Illuminate\Database\Eloquent\Model;

class Marab6 extends Model
{
    protected $fillable = [
        'type_id',
        'aim_dates',
        'remained_days',
        'completion_probability'
    ];
    public function type()
    {
        return $this->hasOne('App\Models\VisCenter\KPI\TypeId','id','type_id')->withDefault();
    }
}
