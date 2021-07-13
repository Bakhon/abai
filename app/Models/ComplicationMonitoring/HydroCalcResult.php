<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class HydroCalcResult extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $connection = 'tbd_cmon';

    public function trunkline_point()
    {
        return $this->setConnection('mysql')->belongsTo(TrunklinePoint::class,'id','trunkline_point_id');
    }

    public function oilPipe()
    {
        return $this->setConnection('mysql')->belongsTo(OilPipe::class);
    }
}
