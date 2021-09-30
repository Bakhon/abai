<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WellTechConnect extends PlainForm
{
    protected $configurationFileName = 'well_tech_connect';

    protected function checkFormPermission(string $action)
    {
        // if (auth()->user()->cannot("bigdata {$action} {$this->configurationFileName}")) {
        //     throw new \Exception("You don't have permissions");
        // }
    }
}