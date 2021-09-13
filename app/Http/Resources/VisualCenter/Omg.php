<?php

namespace App\Http\Resources\VisualCenter;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo;

class Omg extends Dzo {
    protected function getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$fieldName,$periodType)
    {
        $condensateSummary = $companySummary;
        $condensateSummary['id'] = '';
        $condensateSummary['name'] = 'ОМГК';
        $condensateSummary['fact'] = $companySummary['condensateFact'];
        $condensateSummary['plan'] = $companySummary['condensatePlan'];
        $condensateSummary['opek'] = $companySummary['condensateOpek'];
        if ($periodType === 'month') {
            $condensateSummary['monthlyPlan'] = $companySummary['condensatePlan'] * $daysInMonth;
        }
        if ($periodType === 'year') {
            $condensateSummary['yearlyPlan'] = $this->getYearlyPlanBy($filteredYearlyPlan,$fieldName);
            $condensateSummary['plan'] = $this->getCurrentPlanForYear($filteredPlan,'condensatePlan',$type);
            $condensateSummary['opek'] = $this->getCurrentPlanForYear($filteredPlan,'condensateOpek',$type);
        }
        return $condensateSummary;
    }

    protected function getChartData($planRecord,$date,$fact,$factField,$planField,$opekField)
    {
        $condensateSummary = array();
        $condensateSummary['fact'] = $fact[$factField];
        $condensateSummary['plan'] = $planRecord[$planField];
        $condensateSummary['opek'] = $planRecord[$opekField];
        $condensateSummary['date'] = $date;
        $condensateSummary['name'] = 'ОМГК';
        return $condensateSummary;
    }
}