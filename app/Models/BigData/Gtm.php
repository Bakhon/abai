<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\GtmType;
use App\Models\TBDModel;

class Gtm extends TBDModel
{
    protected $table = 'prod.gtm';

    public function gtmType()
    {
        return $this->hasMany(GtmType::class, 'id', 'gtm_type');
    }
}
