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
            
        if(empty($endDate) || $endDate->drill_end_date == null){
            return true;
        }
        return $date >= $endDate->drill_end_date;    
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
            ->table('drill.well_daily_drill')
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

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('data'))) {
            $errors[$this->request->get('data')][] = trans('bd.validation.end_date');
        }

        return $errors;
    }

}


