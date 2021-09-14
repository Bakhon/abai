<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Pki extends Dzo {

    protected $dzoName = 'ПКИ';

    protected function getOilCondensateCalculated($condensateSummary,$pkiSumm,$periodType)
    {
        $summary = $pkiSumm;
        $summary['fact'] += $condensateSummary['fact'];
        $summary['plan'] += $condensateSummary['plan'];
        $summary['opek'] += $condensateSummary['opek'];
        if ($condensateSummary['opek'] == 0) {
            $summary['opek'] += $condensateSummary['plan'];
        }
        if ($periodType === 'month') {
            $summary['monthlyPlan'] += $condensateSummary['monthlyPlan'];
        }
        if ($periodType === 'year') {
            $summary['yearlyPlan'] += $condensateSummary['yearlyPlan'];
        }

        return $summary;
    }

    public function getSumByOtherDzo($summary,$periodType,$type,$id)
    {
        $summary = array(
              'id' => $id,
              'name' => 'ПКИ',
              'fact' => array_sum(array_column($summary, 'fact')),
              'plan' => array_sum(array_column($summary, 'plan')),
              'opek' => array_sum(array_column($summary, 'opek')),
              'monthlyPlan' => array_sum(array_column($summary, 'monthlyPlan')),
              'yearlyPlan' => array_sum(array_column($summary, 'yearlyPlan')),
              'decreaseReasonExplanations' => []
        );
        return $summary;
    }

    protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField)
    {
       $summary = array();
       array_push($summary,$daySummary);
       return $summary;
    }
}