<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\ComplicationMonitoring\OilGas;

class OtherObjects extends Model
{
    protected $fillable = ['name'];

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class, 'other_objects_id', 'id');
    }

    public function oilgas()
    {
        return $this->hasMany(OilGas::class, 'other_objects_id', 'id');
    }
}
