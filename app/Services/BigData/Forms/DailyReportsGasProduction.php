<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DailyReportsGasProduction extends DailyReports
{
    protected $metricCode = 'GASPR';
    protected $configurationFileName = 'daily_reports_gas_prod';
    protected $planField = 'gas_production';


    protected function getMeasuredFieldValues(Org $org, CarbonImmutable $date): Collection
    {
        $wells = $this->getOrgWells($org, $date);

        return DB::connection('tbd')
            ->table('prod.meas_gas_prod')
            ->select('dbeg', 'gas_prod_val', 'well')
            ->where('dbeg', '>=', $date->startOfYear())
            ->where('dbeg', '<=', $date->endOfDay())
            ->whereIn('well', $wells)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->dbeg, 'Asia/Almaty')->format('d.m.Y');
            })
            ->map(function ($items, $currentDate) {
                $dateGas = $items
                    ->map(function ($item) {
                        return $item->gas_prod_val;
                    })->sum();

                return [
                    'date' => Carbon::parse($currentDate, 'Asia/Almaty'),
                    'value' => round($dateGas, 2)
                ];
            });
    }

}