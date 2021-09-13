<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Traits\MapObjectsTrait;

class Well extends Model
{
    use LogsActivity, SoftDeletes, MapObjectsTrait;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at', 'created_at', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function zu()
    {
        return $this->belongsTo(Zu::class);
    }

    public function oilgas()
    {
        return $this->hasMany(OilGas::class);
    }

    public function oilpipes()
    {
        return $this->setConnection('tbd_cmon')->hasMany(OilPipe::class);
    }

    public function omguhe()
    {
        return $this->hasMany(OmgUHE::class);
    }

    public function omgngdu()
    {
        return $this->hasMany(OmgNGDUWell::class);
    }

    public function scopeWithLastOmgngdu($query)
    {
        $query->addSelect(
            [
                'last_omgngdu_id' => OmgNGDUWell::select('id')
                    ->whereColumn('well_id', 'wells.id')
                    ->orderBy('date', 'desc')
                    ->take(1)
            ]
        )->with('lastOmgngdu');
    }

    public function lastOmgngdu()
    {
        return $this->belongsTo(OmgNGDUWell::class)->select(
            'id',
            'date',
            'well_id',
            'daily_fluid_production',
            'daily_oil_production',
            'daily_water_production',
            'bsw',
            'gas_factor',
            'pressure',
            'temperature_well',
            'temperature_zu',
            'sg_oil',
            'sg_gas',
            'sg_water'
        );
    }
}
