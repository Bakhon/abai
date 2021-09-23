<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\OmgNgduTrait;
use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OmgNGDUWell extends Model
{
    use WithHistory, OmgNgduTrait, SoftDeletes;

    protected $guarded = ['id'];

    public function getDailyWaterProductionAttribute()
    {
        if ($this->daily_fluid_production != null AND $this->bsw != null) {
            return round (($this->daily_fluid_production *  $this->bsw)/100 , 2);
        }

        return null;
    }
}
