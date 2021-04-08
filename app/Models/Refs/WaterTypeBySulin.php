<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;
use App\Models\ComplicationMonitoring\WaterMeasurement;

class WaterTypeBySulin extends Model
{
    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class);
    }
}
