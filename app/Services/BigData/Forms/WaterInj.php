<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Jobs\RunPostgresqlProcedure;
use Carbon\Carbon;

class WaterInj extends MeasurementLogForm
{
    protected $configurationFileName = 'water_inj';
    protected $wellCategories = ['INJ'];

    protected function afterSubmit(array $fields, array $filter = [])
    {
        $date = Carbon::parse($filter['date']);
        if ($date->startOfDay() >= Carbon::now()->startOfDay()) {
            return;
        }

        foreach ($fields as $wellId => $value) {
            RunPostgresqlProcedure::dispatch('dmart.sync_well_daily_inj_abai', [$wellId, $date->format('Y-m-d')]);
        }
    }

}