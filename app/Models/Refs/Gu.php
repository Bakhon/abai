<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class Gu extends Model
{
    public function omgca()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OmgCA::class);
    }
}
