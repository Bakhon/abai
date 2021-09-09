<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Refs\Field;
use App\Models\Traits\OmgNgduTrait;
use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OmgNGDU extends Model
{
    use WithHistory, OmgNgduTrait;

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

    public function field()
    {
        return $this->hasOne(Field::class,'id','field_id')->withDefault();
    }

    public function getDailyWaterProductionAttribute()
    {
        if ($this->daily_fluid_production != null AND $this->bsw != null) {
            return round (($this->daily_fluid_production *  $this->bsw)/100 , 2);
        }

        return null;
    }
}
