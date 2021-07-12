<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;

class WellConstr extends PlainForm
{
    protected $configurationFileName = 'well_constr';

    protected function isValidLandingDate($wellId, $landingDate): bool
    {
        $startDate =  DB::connection('tbd')
            ->table('dict.well')
            ->where('id', $wellId)
            ->get('drill_start_date')
            ->first();            
            
        if(empty($startDate->drill_start_date)){
            return true;
        }
        else return $landingDate >= $startDate;    
    }

    
    function isCorrectDepth($dailyDrill, $depth) : bool {
                
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
            
        return ($this->isCorrectDepth($dailyDrill, $depth)) ? true : false ;
    }

        
    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidLandingDate($this->request->get('well'), $this->request->get('landing_date'))) {
            $errors['landing_date'][] = trans('bd.validation.landing_date');
        }

        return $errors;
    }

}