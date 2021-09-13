<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo;

class Kgm extends Dzo {
    private $condensateMultiplier = 0.5 * 0.33;
    private $oilCondensateMultiplier = 0.5;

    protected function getCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$periodType)
    {
        $condensateSummary = $companySummary;
        $condensateSummary['id'] = '';
        $condensateSummary['name'] = 'КГМКМГ';
        $condensateSummary['fact'] *= $this->condensateMultiplier;
        $condensateSummary['plan'] *= $this->condensateMultiplier;
        if ($periodType === 'month') {
            $condensateSummary['monthlyPlan'] *= $this->condensateMultiplier;
        }
        if ($periodType === 'year') {
            $condensateSummary['yearlyPlan'] *= $this->condensateMultiplier;
        }
        $condensateSummary['opek'] *= $this->condensateMultiplier;
        return $condensateSummary;
    }

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