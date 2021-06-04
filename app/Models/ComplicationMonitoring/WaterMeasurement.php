<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\WithHistory;
use App\Models\Refs\OtherObjects;
use App\Models\Refs\WaterTypeBySulin;
use App\Models\Refs\SulphateReducingBacteria;
use App\Models\Refs\HydrocarbonOxidizingBacteria;
use App\Models\Refs\ThionicBacteria;

class WaterMeasurement extends Model
{
    use WithHistory;

    protected $table = 'water_measurements';
    protected $guarded = ['id'];

    public function other_objects()
    {
        return $this->belongsTo(OtherObjects::class,'other_objects_id','id')->withDefault();
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class,'ngdu_id','id')->withDefault();
    }

    public function cdng()
    {
        return $this->belongsTo(Cdng::class,'cdng_id','id')->withDefault();
    }

    public function gu()
    {
        return $this->belongsTo(Gu::class,'gu_id','id')->withDefault();
    }

    public function zu()
    {
        return $this->belongsTo(Zu::class,'zu_id','id')->withDefault();
    }

    public function well()
    {
        return $this->belongsTo(Well::class,'well_id','id')->withDefault();
    }

    public function waterTypeBySulin()
    {
        return $this->belongsTo(WaterTypeBySulin::class,'water_type_by_sulin_id','id')->withDefault();
    }

    public function sulphateReducingBacteria()
    {
        return $this->belongsTo(SulphateReducingBacteria::class,'sulphate_reducing_bacteria_id','id')->withDefault();
    }

    public function hydrocarbonOxidizingBacteria()
    {
        return $this->belongsTo(HydrocarbonOxidizingBacteria::class,'hydrocarbon_oxidizing_bacteria_id','id')->withDefault();
    }

    public function thionicBacteria()
    {
        return $this->belongsTo(ThionicBacteria::class,'thionic_bacteria_id','id')->withDefault();
    }
}
