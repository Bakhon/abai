<?php

namespace App\Services\BigData\Forms;

class DailyReportsWaterProduction extends DailyReports
{
    protected $metricCode = 'WPRD';
    protected $configurationFileName = 'daily_reports_water_prod';
}