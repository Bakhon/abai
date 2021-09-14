<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo;

class Pkkr extends Dzo {

    protected $dzoName = 'ПККР';
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

    protected function getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type)
    {
        $summary = array();
        $summaryByOil = $this->getOilCondensateCalculated($companySummary,$periodType);
        array_push($summary,$summaryByOil);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$periodType)
    {
        $summary = array();
        array_push($summary,$companySummary);
        return $summary;
    }

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField)
    {
        $chartSummary = $daySummary;
        $chartSummary['fact'] *= $this->oilCondensateMultiplier;
        $chartSummary['plan'] *= $this->oilCondensateMultiplier;
        $chartSummary['opek'] *= $this->oilCondensateMultiplier;
        $summary = array();
        array_push($summary,$chartSummary);
        return $summary;
    }
}