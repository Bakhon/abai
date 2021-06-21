<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Refs\Field;
use App\Models\Refs\OtherObjects;

class Corrosion extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public function getBackgroundCorrosionVelocityAttribute($value)
    {
        return $value ? round($value, 2) : $value;
    }

    public function other_objects()
    {
        return $this->hasOne(OtherObjects::class,'id','other_objects_id')->withDefault();
    }

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

    public function field()
    {
        return $this->hasOne(Field::class,'id','field_id')->withDefault();
    }
}
