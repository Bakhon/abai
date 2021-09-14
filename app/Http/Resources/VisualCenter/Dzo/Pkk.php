<?php

namespace App\Http\Resources\VisualCenter\Dzo;

use App\Models\VisCenter\ExcelForm\DzoImportData;
use Carbon\Carbon;
use App\Http\Resources\VisualCenter\Dzo\Dzo;

class Pkk extends Dzo {

    protected $dzoName = 'ПКК';
    private $oilCondensateMultiplier = 0.33;

   protected function getChartData($daySummary,$planRecord,$date,$fact,$factField,$planField,$opekField)
   {
       $daySummary['fact'] *= $this->oilCondensateMultiplier;
       $daySummary['plan'] *= $this->oilCondensateMultiplier;
       $daySummary['opek'] *= $this->oilCondensateMultiplier;
       $summary = array();
       array_push($summary,$daySummary);
       return $summary;
   }
}