<?php

namespace App\Models\VisCenter\KPI;

use Illuminate\Database\Eloquent\Model;

class Abd12 extends Model
{
    protected $fillable = [
        'abdkpi_id',
        'type_id',
        // 'date_col',
        'aim_params',
        // 'fact',
        'remaining_days',
        'expactations_percentage'
    ];
    public function type()
    {
        return $this->hasOne('App\Models\VisCenter\KPI\TypeId','id','type_id')->withDefault();
    }
    public function abdkpi()
    {
        return $this->hasOne('App\Models\VisCenter\KPI\AbdKpiId','id','abdkpi_id')->withDefault();
    }
}