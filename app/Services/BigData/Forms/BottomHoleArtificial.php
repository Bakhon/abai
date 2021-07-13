<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;

class BottomHoleArtificial extends PlainForm
{
    protected $configurationFileName = 'bottom_hole_artificial';

    protected function isValidDate($wellId, $date): bool
    {
        $endDate =  DB::connection('tbd')
            ->table('dict.well')
            ->where('id', $wellId)
            ->get('drill_end_date')
            ->first();            
            
        if(empty($endDate->drill_end_date)){
            return true;
        }
        else return $date >= $endDate;    
    }
    function isCorrectSummofDailyDrill($dailyDrill, $depth) : bool {
                
        if($dailyDrill != 0){
            return $depth < $dailyDrill;
        }
        return true;
    }

    protected function isValidDepth($wellId, $depth):bool
    {
        $dailyDrill =  DB::connection('tbd')
        >table('drill.well_daily_drill')
            ->where('well', $wellId)
            ->get('daily_drill_progress')
            ->sum('daily_drill_progress');
            
        return ($this->isCorrectSummofDailyDrill($dailyDrill, $depth)) ? true : false ;
    }

        
    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidLandingDate($this->request->get('well'), $this->request->get('landing_date'))) {
            $errors['end_date'][] = trans('bd.validation.end_date');
        }

        return $errors;
    }

}


