<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class LostProfits extends Model
{
    public function gu()
    {
        return $this->hasOne(Gu::class,'id','gu_id')->withDefault();
    }
}
