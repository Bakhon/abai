<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\BigData\Well;
use App\Models\TBDModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WellType extends TBDModel
{
    protected $table = 'dict.well_type';
}
