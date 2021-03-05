<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\TBDModel;

class Well extends TBDModel
{
    protected $table = 'tbdi.well';
    protected $guarded = ['id'];

    public function geo()
    {
        return $this->belongsToMany(Geo::class, 'tbdi.well_geo', 'geo_id', 'well_id');
    }
}
