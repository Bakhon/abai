<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DailyDrillKpc extends DailyReports
{   
    const CITS = 0;
    const GS = 1;
    const ALL = 2;
    protected $metricCode = 'CWO';
    protected $configurationFileName = 'daily_drill_kpc';

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);

        $kpc = DB::connection('tbd')
            ->table('dict.well_repair_type')
            ->where('code', 'CWO')
            ->first();

        $data['repair_type'] = $kpc->id;
        return $data;
    }

    protected function getData($filter): array {
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