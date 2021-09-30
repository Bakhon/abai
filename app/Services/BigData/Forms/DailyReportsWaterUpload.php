<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DailyReportsWaterUpload extends DailyReports
{
    protected $metricCode = 'WINJ';
    protected $configurationFileName = 'daily_reports_water_upload';
    protected $planField = 'water_injection';


    protected function getMeasuredFieldValues(Org $org, CarbonImmutable $date): Collection
    {
        $wells = $this->getOrgWells($org, $date);

        $workTime = $this->getWorkTime($wells, $date);

        return DB::connection('tbd')
            ->table('prod.meas_water_inj')
            ->select('dbeg', 'water_inj_val', 'well')
            ->where('dbeg', '>=', $date->startOfYear())
            ->where('dbeg', '<=', $date)
            ->whereIn('well', $wells)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->dbeg)->format('d.m.Y');
            })
            ->map(function ($items, $key) use ($workTime) {
                $dateLiquid = $items
                    ->map(function ($item) use ($workTime) {
                        $date = Carbon::parse($item->dbeg)->format('d.m.Y');
                        if (!isset($workTime[$item->well])) {
                            return 0;
                        }
                        if (!isset($workTime[$item->well][$date])) {
                            return 0;
                        }
                        return $item->water_inj_val * $workTime[$item->well][$date];
                    })
                    ->sum();
                return [
                    'date' => Carbon::parse($key),
                    'value' => $dateLiquid
                ];
            });
    }

}