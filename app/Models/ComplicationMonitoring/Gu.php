<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\MapObjectsTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pipes\GuZuPipe;
use App\Models\Pipes\ZuWellPipe;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Gu extends Model
{
    use LogsActivity, SoftDeletes, MapObjectsTrait;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at', 'created_at', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

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

    public function omgngdu()
    {
        return $this->hasMany(OmgNGDU::class);
    }

    public function omgca()
    {
        return $this->hasMany(OmgCA::class);
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
            'daily_gas_production_in_sib',
            'surge_tank_pressure',
            'sg_oil',
            'sg_gas',
            'sg_water'
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
        return $this->setConnection('tbd_cmon')->hasMany(OilPipe::class);
    }

    public function zuPipes()
    {
        return $this->hasMany(GuZuPipe::class);
    }

    public function wellPipes()
    {
        return $this->hasMany(ZuWellPipe::class);
    }

    public function economical_effect()
    {
        return $this->hasMany(EconomicalEffect::class);
    }

    public function lost_profits()
    {
        return $this->hasMany(LostProfits::class);
    }

    public function buffer_tank()
    {
        return $this->hasMany(BufferTank::class);
    }

    public function pumps()
    {
        return $this->hasMany(Pump::class);
    }

    public function ovens()
    {
        return $this->hasMany(Oven::class);
    }

    public function agzu()
    {
        return $this->hasMany(Agzu::class);
    }

    public function sib()
    {
        return $this->hasMany(Sib::class);
    }

    public function metering_units()
    {
        return $this->hasMany(MeteringUnits::class);
    }
    
    public function zu_cleanings()
    {
        return $this->hasMany(ZusCLeaning::class);
    }
}
