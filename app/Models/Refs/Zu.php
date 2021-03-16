<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgUHE;

class Zu extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function gu()
    {
        return $this->belongsTo(Gu::class);
    }

    public function wells()
    {
        return $this->hasMany(Well::class);
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

    public function omguhe()
    {
        return $this->hasMany(OmgUHE::class);
    }
}
