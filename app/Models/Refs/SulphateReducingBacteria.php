<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class SulphateReducingBacteria extends Model
{
    public function watermeasurement()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\WaterMeasurement::class);
    }
}
