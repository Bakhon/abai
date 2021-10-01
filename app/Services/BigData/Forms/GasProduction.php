<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class GasProduction extends MeasurementLogForm
{
    protected $configurationFileName = 'gas_production';
    protected $wellCategories = ['GAS'];
}