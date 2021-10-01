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
        $bsw = $this->getBsw($wells, $date);

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
            ->map(function ($items, $currentDate) use ($workTime, $bsw) {
                $dateWater = $items
                    ->map(function ($item) use ($workTime, $bsw) {
                        $date = Carbon::parse($item->dbeg, 'Asia/Almaty');

                        if (!isset($workTime[$item->well])) {
                            return 0;
                        }
                        if (!isset($workTime[$item->well][$date->format('d.m.Y')])) {
                            return 0;
                        }

                        $currentBsw = $bsw
                            ->where('well', $item->well)
                            ->where('dbeg', '<=', $date)
                            ->where('dend', '>=', $date)
                            ->first();
                        if (empty($currentBsw)) {
                            return 0;
                        }


                        return $item->liquid * $workTime[$item->well][$date->format(
                                'd.m.Y'
                            )] * $currentBsw->water_cut / 100;
                    })->sum();

                return [
                    'date' => Carbon::parse($currentDate, 'Asia/Almaty'),
                    'value' => round($dateWater, 2)
                ];
            });
    }

    private function getBsw(array $wells, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.meas_water_cut as mwc')
            ->select('mwc.well', 'mwc.water_cut', 'mwc.dbeg', 'mwc.dend')
            ->join('dict.well_activity as wa', 'mwc.activity', 'wa.id')
            ->join('dict.value_type as vt', 'mwc.value_type', 'vt.id')
            ->whereIn('mwc.well', $wells)
            ->where('mwc.dend', '>=', $date->startOfYear())
            ->where('mwc.dbeg', '<=', $date->endOfDay())
            ->where('wa.code', 'PMSR')
            ->where('vt.code', 'MNT')
            ->get()
            ->map(function ($item) {
                $item->dbeg = Carbon::parse($item->dbeg, 'Asia/Almaty');
                $item->dend = Carbon::parse($item->dend, 'Asia/Almaty');
                return $item;
            });
    }

}