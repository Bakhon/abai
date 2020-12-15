<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class Well extends Model
{
    public function omgngdu()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OmgNGDU::class);
    }
}
