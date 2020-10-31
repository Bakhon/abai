<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class WaterMeasurement extends Model
{
    protected $table = 'water_measurements';

    protected $fillable = [
        'date'
    ];

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

    public function zu()
    {
        return $this->hasOne('App\Models\Refs\Zu','id','zu_id')->withDefault();
    }

    public function well()
    {
        return $this->hasOne('App\Models\Refs\Well','id','well_id')->withDefault();
    }

    public function waterTypeBySulin()
    {
        return $this->hasOne('App\Models\Refs\WaterTypeBySulin','id','water_type_by_sulin_id')->withDefault();
    }

    public function sulphateReducingBacteria()
    {
        return $this->hasOne('App\Models\Refs\SulphateReducingBacteria','id','sulphate_reducing_bacteria_id')->withDefault();
    }

    public function hydrocarbonOxidizingBacteria()
    {
        return $this->hasOne('App\Models\Refs\HydrocarbonOxidizingBacteria','id','hydrocarbon_oxidizing_bacteria_id')->withDefault();
    }

    public function thionicBacteria()
    {
        return $this->hasOne('App\Models\Refs\ThionicBacteria','id','thionic_bacteria_id')->withDefault();
    }
}
