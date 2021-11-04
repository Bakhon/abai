<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Pkk extends Dzo {

    protected $dzoName = 'ПКК';
    private $oilCondensateMultiplier = 0.33;

   protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField,$isSummary)
   {
       if ($isSummary) {
           $daySummary['fact'] *= $this->oilCondensateMultiplier;
           $daySummary['plan'] *= $this->oilCondensateMultiplier;
           $daySummary['opek'] *= $this->oilCondensateMultiplier;
       }
       $summary = array();
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