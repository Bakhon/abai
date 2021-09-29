<?php

namespace App\Services\BigData\Forms;

class DailyReportsGasProduction extends DailyReports
{
    protected $metricCode = 'GASPR';
    protected $configurationFileName = 'daily_reports_gas_prod';
}