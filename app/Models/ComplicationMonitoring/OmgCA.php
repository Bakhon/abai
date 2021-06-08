<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OmgCA extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public function ngdu()
    {
        return $this->hasOne(Ngdu::class,'id','ngdu_id')->withDefault();
    }

    public function cdng()
    {
        return $this->hasOne(Cdng::class,'id','cdng_id')->withDefault();
    }

    public function gu()
    {
        return $this->hasOne(Gu::class,'id','gu_id')->withDefault();
    }

    public function zu()
    {
        return $this->hasOne(Zu::class,'id','zu_id')->withDefault();
    }

    public function well()
    {
        return $this->hasOne(Well::class,'id','well_id')->withDefault();
    }
}
