<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class FluidProduction extends MeasurementLogForm
{
    protected $configurationFileName = 'fluid_production';
    protected $wellCategories = ['OIL'];
}