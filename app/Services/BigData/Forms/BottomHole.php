<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;

class BottomHole extends PlainForm
{
    protected $configurationFileName = 'bottom_hole';

    function isCorrectSumOfDailyDrill($dailyDrill, $depth) : bool {        
        
        if($dailyDrill != 0){
            return $depth < $summ;
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

        return ($this->isCorrectSumOfDailyDrill($dailyDrill, $depth)) ? true : false ;
    }

    protected function isValidDate($wellId, $date): bool
    {
        $startDate =  DB::connection('tbd')
            ->table('dict.well')
            ->where('id', $wellId)
            ->get('drill_start_date')
            ->first();            
            
        if(empty($startDate->drill_start_date)){
            return true;
        }
        return $date >= $startDate;    
    }


    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('data'))) {
            $errors['bottom_hole_date'][] = trans('bd.validation.bottom_hole_date');
        }

        return $errors;
    }

}