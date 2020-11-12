<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class GuKormass extends Model
{
    public function kormass()
    {
        return $this->hasOne('App\Models\ComplicationMonitoring\Kormass','id','kormass_id')->withDefault();
    }
}
