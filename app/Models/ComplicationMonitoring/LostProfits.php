<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class LostProfits extends Model
{
    public function gu()
    {
        return $this->hasOne('App\Models\Refs\Gu','id','gu_id')->withDefault();
    }
}
