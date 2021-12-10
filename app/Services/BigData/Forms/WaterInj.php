<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WaterInj extends MeasurementLogForm
{
    protected $configurationFileName = 'water_inj';
    protected $wellCategories = ['INJ'];
}