<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ManualOilPipe extends Model
{
    use LogsActivity, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $connection = 'tbd_cmon';

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at', 'created_at', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function zu()
    {
        return $this->setConnection('mysql')->belongsTo(ManualZu::class);
    }

    public function gu()
    {
        return $this->setConnection('mysql')->belongsTo(ManualGu::class);
    }

    public function well()
    {
        return $this->setConnection('mysql')->belongsTo(ManualWell::class);
    }

    public function pipeType()
    {
        return $this->setConnection('mysql')->belongsTo(PipeType::class, 'type_id', 'id');
    }

    public function coords()
    {
        return $this->setConnection('mysql')->hasMany(PipeCoord::class, 'oil_pipe_id', 'id');
    }

    public function firstCoords()
    {
        return $this->setConnection('mysql')->hasOne(PipeCoord::class)->orderBy('m_distance');
    }

    public function lastCoords()
    {
        return $this->setConnection('mysql')->hasOne(PipeCoord::class)->orderByDesc('m_distance');
    }

    public function hydroCalc()
    {
        return $this->hasOne(HydroCalcResult::class, 'oil_pipe_id');
    }

    public function reverseCalc()
    {
        return $this->hasOne(ReverseCalculation::class, 'oil_pipe_id');
    }

    public function hydroCalcLong()
    {
        return $this->hasMany(HydroCalcLong::class, 'oil_pipe_id')->orderby('segment');
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($pipe) {
            $pipe->coords()->each(function($coord) {
                $coord->delete();
            });
        });
    }

    public function lastHydroCalc()
    {
        return $this->belongsTo(HydroCalcResult::class, 'oil_pipe_id');
    }

    public function scopeWithLastHydroCalc($query)
    {
        $query->addSelect(
            [
                'last_hydro_calc_id' => HydroCalcResult::select('id')
                    ->whereColumn('oil_pipe_id', 'manual_oil_pipes.id')
                    ->orderBy('date', 'desc')
                    ->take(1)
            ]
        )->with('lastHydroCalc');
    }

    public function lastReverseCalc()
    {
        return $this->belongsTo(ReverseCalculation::class, 'oil_pipe_id');
    }

    public function scopeWithLastReverseCalc($query)
    {
        $query->addSelect(
            [
                'last_reverse_calc_id' => ReverseCalculation::select('id')
                    ->whereColumn('oil_pipe_id', 'manual_oil_pipes.id')
                    ->orderBy('date', 'desc')
                    ->take(1)
            ]
        )->with('lastReverseCalc');
    }
}
