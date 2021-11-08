<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Ag extends Dzo {

    protected $dzoName = 'АГ';

    protected function getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodType,$periodEnd)
    {
        $summary = $companySummary;
        $summary['fact'] = $summary['condensateFact'];
        $summary['plan'] = $summary['condensatePlan'];
        $summary['opek'] = $summary['condensateOpek'];
        if ($periodType === 'month') {
            $summary['monthlyPlan'] = $summary['condensatePlan'] * $daysInMonth;
        }
        if ($periodType === 'year') {
            $summary['yearlyPlan'] = $filteredYearlyPlan->first()->gk_plan;
            $summary['plan'] = $this->getPlanByYear($filteredPlan,'plan_kondensat',$periodEnd);
            $summary['opek'] = $this->getPlanByYear($filteredPlan,'plan_kondensat',$periodEnd);
            $summary['condensatePlan'] = $this->getPlanByYear($filteredPlan,'plan_kondensat',$periodEnd);
            $summary['condensateOpek'] = $this->getPlanByYear($filteredPlan,'plan_kondensat',$periodEnd);
        }
        return $summary;
    }

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField,$isSummary)
    {
        $chartSummary = $daySummary;
        $chartSummary['fact'] = $fact[$factField];
        $chartSummary['plan'] = $planRecord[$planField];
        $chartSummary['opek'] = $planRecord[$opekField];
        $summary = array();
        array_push($summary,$chartSummary);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodEnd)
    {
        $summary = array();
        $summaryByCondensate = $this->getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodType,$periodEnd);
        array_push($summary,$summaryByCondensate);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodType,$periodEnd)
    {
        $summary = array();
        $summaryByCondensate = $this->getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$periodType,$periodEnd);
        array_push($summary,$summaryByCondensate);
        return $summary;
    }

    public function getDzoDynamicByMultiplier($fields,$summary)
    {
        return $summary;
    }
}