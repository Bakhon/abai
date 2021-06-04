<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class Cdng extends Model
{
    protected $fillable = ['name'];

    public function gu()
    {
        return $this->hasMany(Gu::class);
    }

    public function zus()
    {
        return $this->hasManyThrough(Zu::class, Gu::class);
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
    }

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
}
