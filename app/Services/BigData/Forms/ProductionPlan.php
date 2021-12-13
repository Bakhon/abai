<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class ProductionPlan extends ProductionProgram
{
    protected $configurationFileName = 'production_plan';
    protected $parentColumn = 'geo';
}