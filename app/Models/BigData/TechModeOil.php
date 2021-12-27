<?php

namespace App\Models\BigData;

use App\Models\TBDModel;

class TechModeOil extends TBDModel
{
    protected $table = 'prod.tech_mode_prod_oil';

    protected $casts = [
        'liquid' => 'decimal:1',
        'oil' => 'decimal:1',
        'oil_density' => 'decimal:1',
        'wcut' => 'decimal:1'
    ];
}
