<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo;

class Pkkr extends Dzo {
    private $oilCondensateMultiplier = 0.33;

    protected function getOilCondensateCalculated($companySummary,$periodType)
    {
        $summary = $companySummary;
        $summary['fact'] *= $this->oilCondensateMultiplier;
        $summary['plan'] *= $this->oilCondensateMultiplier;
        $summary['opek'] *= $this->oilCondensateMultiplier;
        if ($periodType === 'month') {
            $summary['monthlyPlan'] *= $this->oilCondensateMultiplier;
        }
        if ($periodType === 'year') {
            $summary['yearlyPlan'] *= $this->oilCondensateMultiplier;
        }
        return $summary;
    }
}