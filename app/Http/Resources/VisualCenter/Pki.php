<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo;

class Pki extends Dzo {
    protected function getOilCondensateCalculated($condensateSummary,$pkiSumm,$periodType)
    {
        $summary = $pkiSumm;
        $summary['fact'] += $condensateSummary['fact'];
        $summary['plan'] += $condensateSummary['plan'];
        $summary['opek'] += $condensateSummary['opek'];
        if ($condensateSummary['opek'] == 0) {
            $summary['opek'] += $condensateSummary['plan'];
        }
        if ($periodType === 'month') {
            $summary['monthlyPlan'] += $condensateSummary['monthlyPlan'];
        }
        if ($periodType === 'year') {
            $summary['yearlyPlan'] += $condensateSummary['yearlyPlan'];
        }

        return $summary;
    }
}