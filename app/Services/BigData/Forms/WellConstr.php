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

        ($landingDate >= $startDate) ? true : false;     
    }

    protected function isValidDepth($depth):bool
    {
        $dailyDrill =  DB::connection('tbd')
            ->table('prod.daily_drill')
            ->where('id', $wellId)
            ->get('daily_drill_progress');
        $data = sum($dailyDrill);
        ($depth <= $data) ? true : false;  
    }

    
}