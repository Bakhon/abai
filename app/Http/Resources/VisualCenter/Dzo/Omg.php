<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Omg extends Dzo {

    protected $dzoName = 'ОМГ';

    protected function getCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$fieldName,$periodType)
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

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField)
    {
        $condensateSummary = array();
        $condensateSummary['fact'] = $fact[$factField];
        $condensateSummary['plan'] = $planRecord[$planField];
        $condensateSummary['opek'] = $planRecord[$opekField];
        $condensateSummary['date'] = $date;
        $condensateSummary['name'] = 'ОМГК';
        $summary = array();
        array_push($summary,$condensateSummary);
        array_push($summary,$daySummary);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type)
    {
        $summaryByOil = $companySummary;
        $summaryByCondensate = $this->getCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$this->consolidatedFieldsMapping[$type]['condensatePlan'],$periodType);
        $summary = array();
        array_push($summary,$summaryByCondensate);
        array_push($summary,$summaryByOil);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$periodType)
    {
        $summaryByOil = $companySummary;
        $summaryByCondensate = $this->getCondensateCalculated($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$this->consolidatedFieldsMapping[$type]['condensatePlan'],$periodType);
        $summary = array();
        array_push($summary,$summaryByCondensate);
        array_push($summary,$summaryByOil);
        return $summary;
    }
}