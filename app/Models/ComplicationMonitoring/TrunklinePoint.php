<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Pipes\OilPipe;
use App\Models\Refs\Gu;
use App\Models\Refs\Ngdu;
use Illuminate\Database\Eloquent\Model;

class TrunklinePoint extends Model
{
    protected $table = 'trunkline_points';
    protected $guarded = ['id'];

    public function gu()
    {
        return $this->belongsTo(Gu::class, 'gu_id', 'id');
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
    }

    public function oilPipe()
    {
        return $this->belongsTo(OilPipe::class);
    }

    public function trunkline_end_point()
    {
        return $this->belongsTo(TrunklinePoint::class, 'point_end_id', 'id');
    }
}
