<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Kgm extends Dzo {

    protected $dzoName = 'КГМ';
    private $condensateMultiplier = 0.5 * 0.33;
    private $oilCondensateMultiplier = 0.5;

    protected function getCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$periodType)
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

    protected function getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodEnd)
    {
        $summaryByOil = $this->getOilCondensateCalculated($companySummary,$periodType);
        $summaryByCondensate = $this->getCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$periodType);
        $summary = array();
        array_push($summary,$summaryByCondensate);
        array_push($summary,$summaryByOil);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodType,$periodEnd)
    {
        $summary = array();
        array_push($summary,$companySummary);
        return $summary;
    }

    protected function getCondensateForChart($daySummary)
    {
        $condensateSummary = $daySummary;
        $condensateSummary['id'] = '';
        $condensateSummary['name'] = 'КГМКМГ';
        $condensateSummary['fact'] *= $this->condensateMultiplier;
        $condensateSummary['plan'] *= $this->condensateMultiplier;
        $condensateSummary['opek'] *= $this->condensateMultiplier;
        return $condensateSummary;
    }

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField,$isSummary)
    {
       $chartSummary = $daySummary;
       if ($isSummary) {
           $chartSummary['fact'] *= $this->oilCondensateMultiplier;
           $chartSummary['plan'] *= $this->oilCondensateMultiplier;
           $chartSummary['opek'] *= $this->oilCondensateMultiplier;
       }
       $condensateSummary = $this->getCondensateForChart($daySummary);
       $summary = array();
       array_push($summary,$condensateSummary);
       array_push($summary,$chartSummary);
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