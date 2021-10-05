<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WaterProduction extends MeasurementLogForm
{
    protected $configurationFileName = 'water_production';
    protected $wellCategories = ['WTR'];
}