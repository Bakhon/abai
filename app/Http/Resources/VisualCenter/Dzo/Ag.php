<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Ag extends Dzo {

    protected $dzoName = 'АГ';

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

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField)
    {
        $chartSummary = $daySummary;
        $chartSummary['fact'] = $fact[$factField];
        $chartSummary['plan'] = $planRecord[$planField];
        $chartSummary['opek'] = $planRecord[$opekField];
        $summary = array();
        array_push($summary,$chartSummary);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type)
    {
        $summary = array();
        $summaryByCondensate = $this->getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$this->consolidatedFieldsMapping[$type]['condensatePlan'],$periodType);
        array_push($summary,$summaryByCondensate);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$periodType)
    {
        $summary = array();
        $summaryByCondensate = $this->getOilCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$this->consolidatedFieldsMapping[$type]['condensatePlan'],$periodType);
        array_push($summary,$summaryByCondensate);
        return $summary;
    }
}