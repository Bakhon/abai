<?php

namespace App\Models\Refs;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class Gu extends Model
{
    use WithHistory;

    protected $localKey = 'id';
    protected $guarded = ['id'];

    public function cdng()
    {
        return $this->belongsTo(Cdng::class);
    }

    public function zus()
    {
        return $this->hasMany(\App\Models\Refs\Zu::class);
    }

    public function wells()
    {
        return $this->hasManyThrough(\App\Models\Refs\Well::class, \App\Models\Refs\Zu::class);
    }

    public function omgca()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OmgCA::class);
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

    public function corrosion()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\Corrosion::class);
    }

    public function omguhe()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OmgUHE::class);
    }

    public function pipe()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\Pipe::class);
    }

    public function zuPipes()
    {
        return $this->hasMany(\App\Models\Pipes\GuZuPipe::class);
    }

    public function wellPipes()
    {
        return $this->hasMany(\App\Models\Pipes\ZuWellPipe::class);
    }
}
