<?php

namespace App\Models\ComplicationMonitoring;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PipeCoord extends Model
{
    use LogsActivity, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'pipe_coords';
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at', 'created_at', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function oilPipe()
    {
        return $this->setConnection('tbd_cmon')->belongsTo(OilPipe::class);
    }
}
