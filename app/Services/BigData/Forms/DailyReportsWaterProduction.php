<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DailyReportsWaterProduction extends DailyReports
{
    protected $metricCode = 'WPRD';
    protected $configurationFileName = 'daily_reports_water_prod';
    protected $planField = 'water_production';

    protected function getMeasuredFieldValues(Org $org, CarbonImmutable $date): Collection
    {
        $wells = $this->getOrgWells($org, $date);

        $workTime = $this->getWorkTime($wells, $date);

        return DB::connection('tbd')
            ->table('prod.meas_water_prod')
            ->select('dbeg', 'water_prod_val', 'well')
            ->where('dbeg', '>=', $date->startOfYear())
            ->where('dbeg', '<=', $date->endOfDay())
            ->whereIn('well', $wells)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->dbeg, 'Asia/Almaty')->format('d.m.Y');
            })
            ->map(function ($items, $currentDate) use ($workTime) {
                $dateWater = $items
                    ->map(function ($item) use ($workTime) {
                        $date = Carbon::parse($item->dbeg, 'Asia/Almaty');

                        if (!isset($workTime[$item->well])) {
                            return 0;
                        }
                        if (!isset($workTime[$item->well][$date->format('d.m.Y')])) {
                            return 0;
                        }

                        return $item->water_prod_val * $workTime[$item->well][$date->format(
                                'd.m.Y'
                            )];
                    })->sum();

                return [
                    'date' => Carbon::parse($currentDate, 'Asia/Almaty'),
                    'value' => round($dateWater, 2)
                ];
            });
    }

}