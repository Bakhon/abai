<?php

namespace App\Models\Refs;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class Zu extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public function gu()
    {
        return $this->belongsTo(\App\Models\Refs\Gu::class);
    }

    public function wells()
    {
        return $this->hasMany(\App\Models\Refs\Well::class);
    }

    public function omgngdu()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OmgNGDU::class);
    }

    public function watermeasurement()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\WaterMeasurement::class);
    }

    public function oilgas()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OilGas::class);
    }

    public function omguhe()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OmgUHE::class);
    }
}
