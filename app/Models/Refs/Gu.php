<?php

namespace App\Models\Refs;

use App\Models\Pipes\OilPipe;
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

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
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

    public function lastOmgngdu()
    {
        return $this->belongsTo(OmgNGDU::class)->select(
            'id',
            'date',
            'gu_id',
            'daily_fluid_production',
            'daily_oil_production',
            'daily_water_production',
            'bsw',
            'pump_discharge_pressure',
            'heater_output_temperature',
            'editable',
            'daily_gas_production_in_sib',
            'surge_tank_pressure'
        );
    }

    public function scopeWithLastOmgngdu($query)
    {
        $query->addSelect(
            [
                'last_omgngdu_id' => OmgNGDU::select('id')
                    ->whereColumn('gu_id', 'gus.id')
                    ->orderBy('date', 'desc')
                    ->take(1)
            ]
        )->with('lastOmgngdu');
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

    public function oilPipes()
    {
        return $this->hasMany(OilPipe::class);
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
