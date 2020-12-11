<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class Corrosion extends Model
{
    public function other_objects()
    {
        return $this->hasOne('App\Models\Refs\OtherObjects','id','other_objects_id')->withDefault();
    }

    public function ngdu()
    {
        return $this->hasOne('App\Models\Refs\Ngdu','id','ngdu_id')->withDefault();
    }

    public function cdng()
    {
        return $this->hasOne('App\Models\Refs\Cdng','id','cdng_id')->withDefault();
    }

    public function gu()
    {
        return $this->hasOne('App\Models\Refs\Gu','id','gu_id')->withDefault();
    }
}
