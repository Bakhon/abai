<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\HasPlannedEvents;

class MeasWaterProd extends PlainForm
{
    use HasPlannedEvents;

    protected $configurationFileName = 'meas_water_prod';
}