<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmgNGDU extends Model
{
    public function ngdu()
    {
        return $this->hasOne('App\Models\Ngdu','id','ngdu_id')->withDefault();
    }

    public function cdng()
    {
        return $this->hasOne('App\Models\Cdng','id','cdng_id')->withDefault();
    }

    public function gu()
    {
        return $this->hasOne('App\Models\Gu','id','gu_id')->withDefault();
    }

    public function zu()
    {
        return $this->hasOne('App\Models\Zu','id','zu_id')->withDefault();
    }

    public function well()
    {
        return $this->hasOne('App\Models\Well','id','well_id')->withDefault();
    }
}
