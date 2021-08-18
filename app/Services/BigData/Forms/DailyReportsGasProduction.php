<?php

namespace App\Services\BigData\Forms;

class DailyReportsGasProduction extends DailyReports
{

    const CITS = 0;
    const GS = 1;
    const ALL = 2;
    protected $metricCode = 'GASPR';
    protected $configurationFileName = 'daily_reports_gas_prod';

    protected function getData(\stdClass $filter): array
    {
        $data = parent::getReports($filter);
        $result = [];
        $plan = $data->sum('plan');
        $fact = $data->sum('fact');
        switch ($filter->period) {
            case self::DAY:
                $result['plan'] = ['value' => $plan];
                $result['fact'] = $result['daily_fact_cits'] = ['value' => $fact];
                break;
            case self::MONTH:
                $result['month_plan'] = ['value' => $plan];
                $result['month_fact'] = $result['month_fact_cits'] = ['value' => $fact];
                break;
            case self::YEAR:
                $result['year_plan'] = ['value' => $plan];
                $result['year_fact'] = $result['year_fact_cits'] = ['value' => $fact];
                break;
        }

        if ($filter->optionId === self::GS) {
            $result['fact'] = ['value' => 0];
            $result['month_fact'] = ['value' => 0];
            $result['year_fact'] = ['value' => 0];
        }
        $result['daily_fact_gs'] = ['value' => 0];
        $result['month_fact_gs'] = ['value' => 0];
        $result['year_fact_gs'] = ['value' => 0];

        return $result;
    }

}