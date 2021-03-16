<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\TBDModel;

class Well extends TBDModel
{
    protected $table = 'tbdi.well';
    protected $guarded = ['id'];

    public function geo()
    {
        return $this->belongsToMany(Geo::class, 'tbdi.well_geo', 'well_id', 'geo_id');
    }

    public function orgs()
    {
        return $this->belongsToMany(Org::class, 'tbdi.well_org', 'well_id', 'org_id');
    }

    public function techs()
    {
        return $this->belongsToMany(Tech::class, 'tbdi.well_tech', 'well_id', 'tech_id');
    }
}
