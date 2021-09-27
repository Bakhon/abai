<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Omgk extends Dzo {

    public function getDzoDynamicByMultiplier($fields,$summary)
    {
        return $summary;
    }
}