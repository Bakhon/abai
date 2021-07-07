<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WellConstr extends PlainForm
{
    protected $configurationFileName = 'well_constr';


    protected function isValidLandingDate($wellId, $landingDate): bool
    {
        $startDate =  DB::connection('tbd')
            ->table('dict.well')
            ->where('id', $wellId)
            ->get('drill_start_date');

        return $landingDate >= $startDate;    
    }

    protected function isValidDepth($wellId, $depth):bool
    {
        $dailyDrill =  DB::connection('tbd')
            ->table('prod.daily_drill')
            ->where('id', $wellId)
            ->get('daily_drill_progress');
        $data = sum($dailyDrill);

        return $depth <= $data;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'] = trans('bd.validation.depth');
        }

        if (!$this->isValidLandingDate($this->request->get('well'), $this->request->get('landing_date'))) {
            $errors['landing_date'] = trans('bd.validation.landing_date');
        }

        return $errors;
    }

    
}