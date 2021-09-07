<?php

namespace App\Traits;

use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\WaterMeasurement;

trait MapObjectsTrait
{
    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
    }

    public function omgngdu()
    {
        return $this->hasMany(OmgNGDU::class, 'well_id');
    }

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class);
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($object) {
            $object->omgngdu()->each(function($omgngdu) {
                $omgngdu->delete();
            });
        });
    }
}