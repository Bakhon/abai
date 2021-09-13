<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo;

class Ag extends Dzo {
    protected function getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$fieldName,$periodType)
    {
        $summary = $companySummary;
        $summary['fact'] = $summary['condensateFact'];
        $summary['plan'] = $summary['condensatePlan'];
        $summary['opek'] = $summary['condensateOpek'];
        if ($periodType === 'month') {
            $summary['monthlyPlan'] = $summary['condensatePlan'] * $daysInMonth;
        }
        if ($periodType === 'year') {
            $summary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$fieldName);
            $summary['plan'] = $this->getCurrentPlanForYear($filteredPlan,'condensatePlan',$type);
            $summary['opek'] = $this->getCurrentPlanForYear($filteredPlan,'condensateOpek',$type);
        }
        return $summary;
    }

    protected function getChartData($daySummary,$fact,$planRecord,$factField,$planField,$opekField)
    {
        $summary = $daySummary;
        $daySummary['fact'] = $fact[$factField];
        $daySummary['plan'] = $planRecord[$planField];
        $daySummary['opek'] = $planRecord[$opekField];
        return $summary;
    }
}