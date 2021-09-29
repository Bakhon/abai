<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\BigData\Well;
use App\Models\TBDModel;

class Tech extends TBDModel
{
    protected $table = 'dict.tech';

    const TYPE_ZU = 'MS';
    const TYPE_GU = 'GU';
    const TYPE_GZU = 'GMS';
    const TYPE_AGZU = 'AGMS';
    const TYPE_SPGU = 'SSU';
    const TYPE_KNS = 'GPST';
    const TYPE_BKNS = 'MGPST';
    const TYPE_OPPS = 'OPPS';
    const TYPE_OTU = 'OTU';

    public function parentItem()
    {
        return $this->belongsTo(Tech::class, 'parent', 'id');
    }

    public function children()
    {
        return $this->hasMany(Tech::class, 'parent', 'id');
    }

    public function wells()
    {
        return $this->belongsToMany(Well::class, 'prod.well_tech', 'tech', 'well');
    }

    public function type()
    {
        return $this->belongsTo(TechType::class, 'tech_type');
    }
}
