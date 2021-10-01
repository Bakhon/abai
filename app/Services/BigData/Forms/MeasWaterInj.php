<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MeasWaterInj extends MeasLogByMonth
{
    protected $configurationFileName = 'meas_water_inj';

    protected function getRows(CarbonImmutable $date, Collection $wells): array
    {
        $wellIds = $wells->pluck('id')->toArray();

        $techMode = $this->getTechMode($wellIds, $date);
        $pressures = $this->getPressure($wellIds, $date);
        $workTimes = $this->getWorkTime($wellIds, $date);

        $rows = [];
        foreach ($wells as $well) {
            $rows = array_merge($rows, $this->getWellRows($well, $date, $techMode, $pressures, $workTimes));
        }
        return $rows;
    }

    private function getTechMode(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.tech_mode_inj')
            ->whereIn('well', $wellIds)
            ->where('dend', '>=', $date->startOfMonth())
            ->where('dbeg', '<=', $date->endOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                return $items->first();
            });
    }

    private function getPressure(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.meas_water_inj as mwi')
            ->select('mwi.well', 'mwi.pressure_inj', 'mwi.dbeg')
            ->whereIn('mwi.well', $wellIds)
            ->where('mwi.dbeg', '>=', $date->startOfMonth())
            ->where('mwi.dbeg', '<=', $date)
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                $items = $items->groupBy(function ($item) {
                    return Carbon::parse($item->dbeg)->format('j');
                });
                return $items->map(function ($item) {
                    $item = $item->first();
                    return round($item->pressure_inj, 2);
                });
            });
    }

    private function getWellRows(
        Well $well,
        CarbonImmutable $date,
        Collection $techMode,
        Collection $pressures,
        array $workTimes
    ) {
        $pressureRow = [
            'id' => $well->id,
            'uwi' => ['value' => $well->uwi],
            'indicator' => ['value' => trans('bd.forms.meas_water_inj.pressure')],
            'tech' => ['value' => $techMode->get($well->id) ? $techMode->get($well->id)->inj_pressure : 0]
        ];
        $workTimeRow = [
            'id' => $well->id,
            'indicator' => ['value' => trans('bd.forms.meas_water_inj.worktime')]
        ];
        $pressureSumRow = [
            'id' => $well->id,
            'indicator' => ['value' => trans('bd.forms.meas_water_inj.pressure_sum')]
        ];

        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $pressure = $pressures->get($well->id) ? $pressures->get($well->id)->get($monthDay->format('j')) : 0;
            $workTime = $workTimes[$monthDay->format('j')] ?? null;

            $pressureRow[$monthDay->format('d.m.Y')] = [
                'value' => $pressure,
                'is_editable' => true,
                'params' => [
                    'field' => 'pressure',
                    'date' => $monthDay->format('d.m.Y')
                ]
            ];
            $pressureSumRow[$monthDay->format('d.m.Y')] = ['value' => $pressure * $workTime];
            $workTimeRow[$monthDay->format('d.m.Y')] = ['value' => $workTime ?? 0];

            $monthDay = $monthDay->addDay();
        }

        return [$pressureRow, $pressureSumRow, $workTimeRow, []];
    }

    protected function getColumns(CarbonImmutable $date): array
    {
        $columns = $this->getFields()->toArray();

        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $columns[] = [
                'code' => $monthDay->format('d.m.Y'),
                'type' => 'text',
                'is_editable' => false,
                'title' => $monthDay->format('j')
            ];
            $monthDay = $monthDay->addDay();
        }

        return $columns;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        $field = $this->request->get('params')['field'];
        $date = $this->request->get('params')['date'];
        if ($field === 'pressure') {
            $pressure = DB::connection('tbd')
                ->table('prod.meas_water_inj')
                ->where('dbeg', Carbon::parse($date))
                ->where('well', $this->request->get('well_id'))
                ->first();

            if (empty($pressure)) {
                DB::connection('tbd')
                    ->table('prod.meas_water_inj')
                    ->insert(
                        [
                            'dbeg' => Carbon::parse($date),
                            'dend' => Well::DEFAULT_END_DATE,
                            'well' => $this->request->get('well_id'),
                            'pressure_inj' => $params['value']
                        ]
                    );
                return;
            }

            DB::connection('tbd')
                ->table('prod.meas_water_inj')
                ->where('id', $pressure->id)
                ->update(
                    [
                        'pressure_inj' => $params['value']
                    ]
                );
        }
    }
}