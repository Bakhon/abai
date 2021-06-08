<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class ReverseCalculation extends Model
{
    protected $guarded = ['id'];

    public function oilPipe()
    {
        return $this->belongsTo(OilPipe::class);
    }
}
