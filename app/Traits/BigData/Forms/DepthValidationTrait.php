<?php

namespace App\Traits\BigData\Forms;
use Illuminate\Support\Facades\DB;

trait DepthValidationTrait
{
    function isCorrectSummofDailyDrill($dailyDrill, $depth) : bool {

        if($dailyDrill == 0){
            return $depth < 10000;
        }
        return $depth < $dailyDrill;
    }
    protected function isValidDepth($wellId, $depth):bool
    {
        
        $dailyDrill =  DB::connection('tbd')
            ->table('drill.well_daily_drill')
            ->where('well', $wellId)
            ->get('daily_drill_progress')
            ->sum('daily_drill_progress');

        return $this->isCorrectSummofDailyDrill($dailyDrill, $depth);
    }
       
}