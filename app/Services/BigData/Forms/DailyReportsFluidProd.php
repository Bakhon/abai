<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DailyReportsFluidProd extends DailyReports
{
    protected $metricCode = 'FLR';
    protected $configurationFileName = 'daily_reports_fluid_prod';
    protected $planField = 'liquid_production';


    protected function getMeasuredFieldValues(Org $org, CarbonImmutable $date): Collection
    {
        $wells = $this->getOrgWells($org, $date);

        $workTime = $this->getWorkTime($wells, $date);

        return DB::connection('tbd')
            ->table('prod.meas_liq')
            ->select('dbeg', 'liquid', 'well')
            ->where('dbeg', '>=', $date->startOfYear())
            ->where('dbeg', '<=', $date->endOfDay())
            ->whereIn('well', $wells)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->dbeg, 'Asia/Almaty')->format('d.m.Y');
            })
            ->map(function ($items, $key) use ($workTime) {
                $dateLiquid = $items
                    ->map(function ($item) use ($workTime) {
                        $date = Carbon::parse($item->dbeg, 'Asia/Almaty')->format('d.m.Y');
                        if (!isset($workTime[$item->well])) {
                            return 0;
                        }
                        if (!isset($workTime[$item->well][$date])) {
                            return 0;
                        }
                        return $item->liquid * $workTime[$item->well][$date];
                    })
                    ->sum();
                return [
                    'date' => Carbon::parse($key, 'Asia/Almaty'),
                    'value' => $dateLiquid
                ];
            });
    }

}