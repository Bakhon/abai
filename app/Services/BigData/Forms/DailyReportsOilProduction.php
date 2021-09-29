<?php

namespace App\Services\BigData\Forms;

class DailyReportsOilProduction extends DailyReports
{
    protected $metricCode = 'OIL';
    protected $configurationFileName = 'daily_reports_oil_prod';
}