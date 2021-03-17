<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OmgNGDU extends Model
{
    use WithHistory;

    protected $guarded = ['id'];
    protected $table = 'omg_n_g_d_u_s_1';

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

    public function zu()
    {
        return $this->hasOne('App\Models\Refs\Zu','id','zu_id')->withDefault();
    }

    public function well()
    {
        return $this->hasOne('App\Models\Refs\Well','id','well_id')->withDefault();
    }

    public function field()
    {
        return $this->hasOne('App\Models\Refs\Field','id','field_id')->withDefault();
    }
}
