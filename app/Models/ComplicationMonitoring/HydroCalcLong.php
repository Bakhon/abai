<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class HydroCalcLong extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $connection = 'tbd_cmon';

    public function oilPipe()
    {
        return $this->setConnection('mysql')->belongsTo(OilPipe::class);
    }
}
