<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class WaterPipePoint extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function oilPipe()
    {
        return $this->setConnection('tbd_cmon')->belongsTo(OilPipe::class);
    }

    public function oilPipeCoord()
    {
        return $this->belongsTo(PipeCoord::class);
    }
}
