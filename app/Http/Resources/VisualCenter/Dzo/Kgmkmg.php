<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Kgmkmg extends Dzo {

    private $condensateMultiplier = 0.5 * 0.33;

    public function getDzoDynamicByMultiplier($fields,$summary)
    {
        $oilSummary = $summary;
        foreach($fields as $fieldName) {
            $oilSummary[$fieldName] *= $this->condensateMultiplier;
        }

        return $oilSummary;
    }
}