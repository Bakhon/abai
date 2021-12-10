<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;

class PerfType extends TBDModel
{
    public const ISOLATION_ID = 2;
    public const EXPLOSIVE_PACKER_ID = 7;

    protected $table = 'dict.perf_type';
}