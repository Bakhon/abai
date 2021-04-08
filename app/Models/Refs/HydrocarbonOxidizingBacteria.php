<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;
use App\Models\ComplicationMonitoring\WaterMeasurement;

class HydrocarbonOxidizingBacteria extends Model
{
    protected $fillable = ['name'];

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class);
    }
}
