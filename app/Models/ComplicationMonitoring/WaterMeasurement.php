<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\WithHistory;

class WaterMeasurement extends Model
{
    use WithHistory;

    protected $table = 'water_measurements';
    protected $guarded = ['id'];

    public function other_objects()
    {
        return $this->belongsTo('App\Models\Refs\OtherObjects','other_objects_id','id')->withDefault();
    }

    public function ngdu()
    {
        return $this->belongsTo('App\Models\Refs\Ngdu','ngdu_id','id')->withDefault();
    }

    public function cdng()
    {
        return $this->belongsTo('App\Models\Refs\Cdng','cdng_id','id')->withDefault();
    }

    public function gu()
    {
        return $this->belongsTo('App\Models\Refs\Gu','gu_id','id')->withDefault();
    }

    public function zu()
    {
        return $this->belongsTo('App\Models\Refs\Zu','zu_id','id')->withDefault();
    }

    public function well()
    {
        return $this->belongsTo('App\Models\Refs\Well','well_id','id')->withDefault();
    }

    public function waterTypeBySulin()
    {
        return $this->belongsTo('App\Models\Refs\WaterTypeBySulin','water_type_by_sulin_id','id')->withDefault();
    }

    public function sulphateReducingBacteria()
    {
        return $this->belongsTo('App\Models\Refs\SulphateReducingBacteria','sulphate_reducing_bacteria_id','id')->withDefault();
    }

    public function hydrocarbonOxidizingBacteria()
    {
        return $this->belongsTo('App\Models\Refs\HydrocarbonOxidizingBacteria','hydrocarbon_oxidizing_bacteria_id','id')->withDefault();
    }

    public function thionicBacteria()
    {
        return $this->belongsTo('App\Models\Refs\ThionicBacteria','thionic_bacteria_id','id')->withDefault();
    }
}
