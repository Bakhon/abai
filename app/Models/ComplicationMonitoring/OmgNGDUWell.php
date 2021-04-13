<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OmgNGDUWell extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public function zu()
    {
        return $this->hasOne('App\Models\Refs\Zu','id','zu_id')->withDefault();
    }

    public function well()
    {
        return $this->hasOne('App\Models\Refs\Well','id','well_id')->withDefault();
    }

    public function getDailyWaterProductionAttribute()
    {
        return round (($this->daily_fluid_production * $this->bsw)/100 , 2);
    }
}
