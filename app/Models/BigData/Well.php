<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\TBDModel;

class Well extends TBDModel
{

    const WELL_STATUS_IN_WORK = 3;
    const WELL_STATUS_ACCUMULATION = 1024;
    const WELL_STATUS_PERIODIC = 7;

    const WELL_ACTIVE_STATUSES = [
        self::WELL_STATUS_IN_WORK,
        self::WELL_STATUS_ACCUMULATION,
        self::WELL_STATUS_PERIODIC
    ];

    protected $table = 'tbdi.well';
    protected $guarded = ['id'];

    public function geo()
    {
        return $this->belongsToMany(Geo::class, 'tbdi.well_geo', 'geo_id', 'well_id');
    }
}
