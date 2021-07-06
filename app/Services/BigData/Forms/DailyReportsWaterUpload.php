<?php

namespace App\Services\BigData\Forms;

class DailyReportsWaterUpload extends DailyReports
{

    const CITS = 0;
    const GS = 1;
    const ALL = 2;
    protected $metricCode = 'WINJ';
    protected $configurationFileName = 'daily_reports_water_upload';

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