<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Pipes\MapPipe;
use Illuminate\Database\Eloquent\Model;

class HydroCalcResult extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function trunkline_point()
    {
        return $this->belongsTo(TrunklinePoint::class,'id','trunkline_point_id');
    }

    public function map_pipe()
    {
        return $this->belongsTo(MapPipe::class);
    }
}
