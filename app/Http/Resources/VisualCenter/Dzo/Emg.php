<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Emg extends Dzo {

    protected $dzoName = 'ЭМГ';

    protected function getDzoBySummaryOilCondensate($companySummary,$periodType,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type)
    {
        $summary = array();
        array_push($summary,$companySummary);
        return $summary;
    }

    protected function getDzoBySummaryOilCondensateWithoutKMG($companySummary,$filteredYearlyPlan,$filteredPlan,$daysInMonth,$type,$periodType)
    {
        $summary = array();
        array_push($summary,$companySummary);
        return $summary;
    }

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField,$isSummary)
    {
       $summary = array();
       array_push($summary,$daySummary);
       return $summary;
    }

    public function getDzoDynamicByMultiplier($fields,$summary)
    {
        return $summary;
    }
}