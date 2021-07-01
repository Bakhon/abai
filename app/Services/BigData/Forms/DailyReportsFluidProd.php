<?php

namespace App\Services\BigData\Forms;
use Carbon\Carbon;

class DailyReportsFluidProd extends DailyReports
{

    const CITS = 0;
    const GS = 1;
    const ALL = 2;
    protected $metricCode = 'FLR';
    protected $configurationFileName = 'daily_reports_fluid_prod';

    protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void
    {
        /** TODO метод для сохранения значения поля */
    }

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