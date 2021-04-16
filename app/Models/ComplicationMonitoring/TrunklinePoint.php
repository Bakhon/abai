<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Pipes\MapPipe;
use App\Models\Refs\Gu;
use App\Models\Refs\Ngdu;
use Illuminate\Database\Eloquent\Model;

class TrunklinePoint extends Model
{
    protected $table = 'trunkline_points';
    protected $guarded = ['id'];

    public function gu()
    {
        return $this->belongsTo(Gu::class);
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
    }

    public function map_pipe()
    {
        return $this->belongsTo(MapPipe::class);
    }

    public function trunkline_point()
    {
        return $this->belongsTo(TrunklinePoint::class, 'point_end_id', 'id');
    }
}
