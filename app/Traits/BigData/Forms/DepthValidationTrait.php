<?php

namespace App\Traits\BigData\Forms;
use Illuminate\Support\Facades\DB;

trait DepthValidationTrait
{
    function isCorrectSummofDailyDrill($dailyDrill, $depth) : bool {
        echo $depth ;
        
        if($dailyDrill != 0){
            return $depth < $dailyDrill;
        }
        return true;
    }
    protected function isValidDepth($wellId, $depth):bool
    {
        
        $dailyDrill =  DB::connection('tbd')
            ->table('drill.well_daily_drill')
            ->where('well', $wellId)
            ->get('daily_drill_progress')
            ->sum('daily_drill_progress');

        return ($this->isCorrectSummofDailyDrill($dailyDrill, $depth)) ? true : false ;
    }
       
}