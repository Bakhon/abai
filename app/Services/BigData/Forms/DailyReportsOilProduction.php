<?php

namespace App\Services\BigData\Forms;
use Carbon\Carbon;

class DailyReportsOilProduction extends DailyReports
{

    const CITS = 0;
    const GS = 1;
    const ALL = 2;
    protected $metricCode = 'OIL';
    protected $configurationFileName = 'daily_reports_oil_prod';

    protected function saveHistory(string $field, $value): void
    {
        /** TODO метод для сохранения истории изменений */
    }

    protected function getData($filter) {
        $data = parent::getData($filter);
        $result = [
            'id' => 0,
            'plan' => $data->sum('plan'),
        ];
        $result['fact'] = $data->sum('fact');
        if (in_array($filter->optionId, [self::ALL, self::GS])) {
            $result['fact'] = 0;
        }

        return $result;
    }

}