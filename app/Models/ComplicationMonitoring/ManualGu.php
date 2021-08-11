<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ManualGu extends Model
{
    use LogsActivity, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at', 'created_at', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

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
        return $this->hasMany(ManualZu::class);
    }

    public function wells()
    {
        return $this->hasManyThrough(ManualWell::class, ManualZu::class);
    }

    public function omgca()
    {
        return $this->hasMany(OmgCA::class, 'gu_id');
    }

    public function omgngdu()
    {
        return $this->hasMany(OmgNGDU::class, 'gu_id');
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
                    ->whereColumn('gu_id', 'manual_gus.id')
                    ->orderBy('date', 'desc')
                    ->take(1)
            ]
        )->with('lastOmgngdu');
    }

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class, 'gu_id');
    }

    public function oilgas()
    {
        return $this->hasMany(OilGas::class, 'gu_id');
    }

    public function corrosion()
    {
        return $this->hasMany(Corrosion::class, 'gu_id');
    }

    public function omguhe()
    {
        return $this->hasMany(OmgUHE::class, 'gu_id');
    }

    public function oilPipes()
    {
        return $this->setConnection('tbd_cmon')->hasMany(ManualOilPipe::class);
    }
}
