<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class OilPipe extends Model
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

    public function zu()
    {
        return $this->belongsTo(Zu::class);
    }

    public function gu()
    {
        return $this->belongsTo(Gu::class);
    }

    public function well()
    {
        return $this->belongsTo(Well::class);
    }

    public function pipeType()
    {
        return $this->belongsTo(PipeType::class, 'type_id', 'id');
    }

    public function coords()
    {
        return $this->hasMany(PipeCoord::class, 'oil_pipe_id', 'id');
    }

    public function firstCoords()
    {
        return $this->hasOne(PipeCoord::class)->orderBy('m_distance');
    }

    public function lastCoords()
    {
        return $this->hasOne(PipeCoord::class)->orderByDesc('m_distance');
    }

    public function hydroCalc()
    {
        return $this->hasOne(HydroCalcResult::class);
    }

    public function reverseCalc()
    {
        return $this->hasOne(ReverseCalculation::class);
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
        return $this->belongsTo(OmgNGDU::class);
    }

    public function scopeWithLastHydroCalc($query)
    {
        $query->addSelect(
            [
                'last_hydro_calc_id' => HydroCalcResult::select('id')
                    ->whereColumn('oil_pipe_id', 'oil_pipes.id')
                    ->orderBy('date', 'desc')
                    ->take(1)
            ]
        )->with('lastHydroCalc');
    }

    public function lastReverseCalc()
    {
        return $this->belongsTo(OmgNGDU::class);
    }

    public function scopeWithLastReverseCalc($query)
    {
        $query->addSelect(
            [
                'last_reverse_calc_id' => ReverseCalculation::select('id')
                    ->whereColumn('oil_pipe_id', 'oil_pipes.id')
                    ->orderBy('date', 'desc')
                    ->take(1)
            ]
        )->with('lastReverseCalc');
    }
}
