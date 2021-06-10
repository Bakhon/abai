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

    public function speedFlowGuUpsv()
    {
        return $this->hasOne(HydroCalcResult::class);
    }

    public function speedFlowWellGu()
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
}
