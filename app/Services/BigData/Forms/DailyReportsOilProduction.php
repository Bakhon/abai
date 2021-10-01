<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DailyReportsOilProduction extends DailyReports
{
    protected $metricCode = 'OIL';
    protected $configurationFileName = 'daily_reports_oil_prod';
    protected $planField = 'oil_production';

    protected function getMeasuredFieldValues(Org $org, CarbonImmutable $date): Collection
    {
        $wells = $this->getOrgWells($org, $date);

        $workTime = $this->getWorkTime($wells, $date);
        $oilDensity = $this->getOilDensity($wells, $date);
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
            ->map(function ($items, $currentDate) use ($workTime, $bsw, $oilDensity) {
                $dateOil = $items
                    ->map(function ($item) use ($workTime, $bsw, $oilDensity) {
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

                        $currentOilDensity = $oilDensity
                            ->where('well', $item->well)
                            ->where('dbeg', '<=', $date)
                            ->where('dend', '>=', $date)
                            ->first();
                        if (empty($currentOilDensity)) {
                            return 0;
                        }

                        return ($item->liquid * (1 - $currentBsw->water_cut / 100) * $currentOilDensity->oil_density);
                    })->sum();

                return [
                    'date' => Carbon::parse($currentDate, 'Asia/Almaty'),
                    'value' => round($dateOil, 2)
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

    private function getOilDensity(array $wells, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.tech_mode_prod_oil')
            ->select('dbeg', 'dend', 'oil_density', 'well')
            ->whereIn('well', $wells)
            ->where('dend', '>=', $date->startOfYear())
            ->where('dbeg', '<=', $date->endOfDay())
            ->get()
            ->map(function ($item) {
                $item->dbeg = Carbon::parse($item->dbeg, 'Asia/Almaty');
                $item->dend = Carbon::parse($item->dend, 'Asia/Almaty');
                return $item;
            });
    }

}