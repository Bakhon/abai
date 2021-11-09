<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Tsho extends Dzo {

    protected $dzoName = 'ТШО';
    private $oilCondensateMultiplier = 0.2;

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

    protected function getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodEnd)
    {
        $summary = array();
        $summaryByOil = $this->getOilCondensateCalculated($companySummary,$periodType);
        array_push($summary,$summaryByOil);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodType,$periodEnd)
    {
        $summary = array();
        array_push($summary,$companySummary);
        return $summary;
    }

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField,$isSummary)
    {
       $summary = array();
       if ($isSummary) {
           $daySummary['fact'] *= $this->oilCondensateMultiplier;
           $daySummary['plan'] *= $this->oilCondensateMultiplier;
           $daySummary['opek'] *= $this->oilCondensateMultiplier;
       }
       array_push($summary,$daySummary);
       return $summary;
    }

    public function getDzoDynamicByMultiplier($fields,$summary)
    {
       $oilSummary = $summary;
       foreach($fields as $fieldName) {
           $oilSummary[$fieldName] *= $this->oilCondensateMultiplier;
       }

       return $oilSummary;
    }
}