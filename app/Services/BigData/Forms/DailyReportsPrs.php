<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class DailyReportsPrs extends DailyReports
{
    protected $configurationFileName = 'daily_reports_prs';
   
    const CITS = 0;
    const GS = 1;
    const ALL = 2;
    protected $metricCode = 'WLO';
    protected function getData($filter): array {
        $data = parent::getReports($filter);
        $result = [];
        $plan = $data->sum('plan');
        $fact = $data->sum('fact');
        $data = $data->get('machine_type');
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
        $result['machine_type'] = ['value'=>$this->request->get('machine_type')];
        $result['contractor'] = ['value'=>$this->request->get('contractor')];
        $result['work_done'] = ['value'=>$this->request->get('work_done')];
        $result['repair_work_type'] = ['value'=>$this->request->get('repair_work_type')];
        return $result;
    }

}
