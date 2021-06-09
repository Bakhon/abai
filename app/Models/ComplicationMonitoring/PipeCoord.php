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

    public function oilPipe()
    {
        return $this->belongsTo(OilPipe::class);
    }
}
