<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Refs\Field;
use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OmgNGDU extends Model
{
    use WithHistory;

    protected $guarded = ['id'];
    protected $table = 'omg_n_g_d_u_s_1';

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

    public function field()
    {
        return $this->hasOne(Field::class,'id','field_id')->withDefault();
    }

    public function getDailyWaterProductionAttribute()
    {
        return round (($this->daily_fluid_production *  $this->bsw)/100 , 2);
    }
}
