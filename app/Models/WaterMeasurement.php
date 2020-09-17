<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterMeasurement extends Model
{
    public function other_objects()
    {
        return $this->hasOne('App\Models\OtherObjects','id','other_objects_id')->withDefault();
    }

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

    public function waterTypeBySulin()
    {
        return $this->hasOne('App\Models\WaterTypeBySulin','id','water_type_by_sulin_id')->withDefault();
    }

    public function sulphateReducingBacteria()
    {
        return $this->hasOne('App\Models\SulphateReducingBacteria','id','sulphate_reducing_bacteria_id')->withDefault();
    }

    public function hydrocarbonOxidizingBacteria()
    {
        return $this->hasOne('App\Models\HydrocarbonOxidizingBacteria','id','hydrocarbon_oxidizing_bacteria_id')->withDefault();
    }

    public function thionicBacteria()
    {
        return $this->hasOne('App\Models\ThionicBacteria','id','thionic_bacteria_id')->withDefault();
    }
}
