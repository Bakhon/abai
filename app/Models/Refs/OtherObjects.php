<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class OtherObjects extends Model
{
    public function watermeasurement()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\WaterMeasurement::class, 'other_objects_id', 'id');
    }

    public function oilgas()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OilGas::class, 'other_objects_id', 'id');
    }
}
