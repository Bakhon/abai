<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class Ngdu extends Model
{
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

    public function corrosion()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\Corrosion::class);
    }
}
