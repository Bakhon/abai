<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OmgNGDUZu extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public function zu()
    {
        return $this->hasOne(Zu::class,'id','zu_id');
    }

    public function manual_zu()
    {
        return $this->hasOne(ManualZu::class,'id','zu_id');
    }

    public function getDailyWaterProductionAttribute()
    {
        if ($this->daily_fluid_production != null AND $this->bsw != null) {
            return round (($this->daily_fluid_production *  $this->bsw)/100 , 2);
        }

        return null;
    }
}
