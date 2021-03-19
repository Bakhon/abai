<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;
use App\Models\ComplicationMonitoring\OmgCA;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\Pipe;
use App\Models\Pipes\GuZuPipe;
use App\Models\Pipes\ZuWellPipe;

class Gu extends Model
{
    protected $localKey = 'id';
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function cdng()
    {
        return $this->belongsTo(Cdng::class);
    }

    public function zus()
    {
        return $this->hasMany(Zu::class);
    }

    public function wells()
    {
        return $this->hasManyThrough(Well::class, Zu::class);
    }

    public function omgca()
    {
        return $this->hasMany(OmgCA::class);
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

    public function pipe()
    {
        return $this->hasMany(Pipe::class);
    }

    public function zuPipes()
    {
        return $this->hasMany(GuZuPipe::class);
    }

    public function wellPipes()
    {
        return $this->hasMany(ZuWellPipe::class);
    }
}
