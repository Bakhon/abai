<?php

namespace App\Models\VizCenter;

use Illuminate\Database\Eloquent\Model;

class Abd35 extends Model
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
        return $this->hasOne('App\Models\VizCenter\TypeId','id','type_id')->withDefault();
    }
    public function abdkpi()
    {
        return $this->hasOne('App\Models\VizCenter\AbdKpiId','id','abdkpi_id')->withDefault();
    } //
}
