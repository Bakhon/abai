<?php

namespace App\Models\Refs;

use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use Illuminate\Database\Eloquent\Model;

class Ngdu extends Model
{
    public function omgngdu()
    {
        return $this->hasMany(OmgNGDU::class);
    }

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class);
    }

    public function oilgas()
    {
        return $this->hasMany(OilGas::class);
    }

    public function corrosion()
    {
        return $this->hasMany(Corrosion::class);
    }

    public function omguhe()
    {
        return $this->hasMany(OmgUHE::class);
    }

    public function cdng()
    {
        return $this->hasMany(Cdng::class);
    }

    public function gu()
    {
        return $this->hasMany(Gu::class);
    }

    public function zus()
    {
        return $this->hasManyThrough(Zu::class, Gu::class);
    }
}
