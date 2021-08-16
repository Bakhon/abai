<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class ReverseCalculation extends Model
{
    protected $guarded = ['id'];
    protected $connection = 'tbd_cmon';

    public function oilPipe()
    {
        return $this->belongsTo(OilPipe::class);
    }
}
