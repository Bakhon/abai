<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Jobs\RunPostgresqlProcedure;
use Carbon\Carbon;

class FluidProduction extends MeasurementLogForm
{
    protected $configurationFileName = 'fluid_production';
    protected $wellCategories = ['OIL'];

    protected function afterSubmit(array $fields, array $filter = [])
    {
        $date = Carbon::parse($filter['date']);
        if ($date->startOfDay() >= Carbon::now()->startOfDay()) {
            return;
        }

        foreach ($fields as $wellId => $value) {
            RunPostgresqlProcedure::dispatch('dmart.sync_well_daily_prod_oil_abai', [$wellId, $date->format('Y-m-d')]);
        }
    }
}