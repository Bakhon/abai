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

    protected function isValidDepthofBottomHole($wellId, $depth):bool
    {
        
        $bottomHole =  DB::connection('tbd')
            ->table('prod.bottom_hole as pb')
            ->where('pb.well', $wellId)
            ->where('bt.code','HUD')
            ->leftjoin('dict.bottom_hole_type as bt', 'pb.bottom_hole_type','bt.id' )            
            ->get('pb.depth');       
        
        return $depth <= $bottomHole;
    }

       
}