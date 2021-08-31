<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Drilling extends DailyReports
{
    const CITS = 0;
    const GS = 1;
    const ALL = 2;
    protected $configurationFileName = 'drilling';

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
        $result['daily_drill_progress'] = ['value' => 0];
        $result['depth'] = ['value' => 0];
        $result['well_status_type'] = ['value'=>$this->request->get('well_status_type')];
        $result['work_name'] = ['value'=>$this->request->get('work_name')];
        $result['liquid_density'] = ['value'=>$this->request->get('liquid_density')];
        $result['liquid_crust'] = ['value'=>$this->request->get('liquid_crust')];
        $result['liquid_viscosity'] =  ['value'=>$this->request->get('liquid_viscosity')];
        $result['liquid_ph'] = ['value'=>$this->request->get('liquid_ph')];
        $result['luquid_water_yield'] = ['value'=>$this->request->get('luquid_water_yield')];
        $result['drill_chisel'] =['value'=>$this->request->get('drill_chisel')];
        $result['diameter'] = ['value'=>$this->request->get('diameter')];
        $result['drill_column_type'] = ['value'=>$this->request->get('drill_column_type')];
        
        return $result;
    }
}