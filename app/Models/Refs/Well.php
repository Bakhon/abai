<?php

namespace App\Models\Refs;

use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use Illuminate\Database\Eloquent\Model;

class Well extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function zu()
    {
        return $this->belongsTo(Zu::class);
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

    public function omgngdu_well()
    {
        return $this->hasMany(OmgNGDUWell::class);
    }
}
