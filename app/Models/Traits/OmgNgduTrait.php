<?php
namespace App\Models\Traits;


use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\ManualGu;
use App\Models\ComplicationMonitoring\ManualWell;
use App\Models\ComplicationMonitoring\ManualZu;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;

trait OmgNgduTrait
{
    public function gu()
    {
        return $this->hasOne(Gu::class,'id','gu_id');
    }

    public function manualGu()
    {
        return $this->hasOne(ManualGu::class,'id','gu_id');
    }

    public function zu()
    {
        return $this->hasOne(Zu::class,'id','zu_id');
    }

    public function manualZu()
    {
        return $this->hasOne(ManualZu::class,'id','zu_id');
    }

    public function well()
    {
        return $this->hasOne(Well::class,'id','well_id');
    }

    public function manualWell()
    {
        return $this->hasOne(ManualWell::class,'id','well_id');
    }
}
