<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class Cdng extends Model
{
    public function omgngdu()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OmgNGDU::class);
    }
}
