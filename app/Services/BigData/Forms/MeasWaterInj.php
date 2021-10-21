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
        $waterInjs = $this->getWaterInj($wellIds, $date);
        $workTimes = $this->getWorkTime($wellIds, $date);

        $rows = [];
        foreach ($wells as $well) {
            $rows = array_merge($rows, $this->getWellRows($well, $date, $techMode, $waterInjs, $workTimes));
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

    private function getWaterInj(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.meas_water_inj as mwi')
            ->select('mwi.well', 'mwi.pressure_inj', 'mwi.water_inj_val', 'mwi.dbeg')
            ->whereIn('mwi.well', $wellIds)
            ->where('mwi.dbeg', '>=', $date->startOfMonth())
            ->where('mwi.dbeg', '<=', $date->endOfDay())
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                $items = $items->groupBy(function ($item) {
                    return Carbon::parse($item->dbeg)->format('j');
                });
                return $items->map(function ($item) {
                    $item = $item->first();
                    return [
                        'pressure' => round((int)$item->pressure_inj, 2),
                        'water_inj' => round((int)$item->water_inj_val, 2),
                    ];
                });
            });
    }

    private function getWellRows(
        Well $well,
        CarbonImmutable $date,
        Collection $techMode,
        Collection $waterInjs,
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
        $waterInjRow = [
            'id' => $well->id,
            'indicator' => ['value' => trans('bd.forms.meas_water_inj.pressure_sum')]
        ];
        $workTime = $workTimes[$well->id] ?? null;
        $monthDay = $date->startOfMonth();

        while ($monthDay <= $date) {
            $waterInj = $waterInjs->get($well->id) ? $waterInjs->get($well->id)->get($monthDay->format('j')) : null;
            $dailyWorkTime = $workTime ? ($workTime[$monthDay->format('j')]['value'] ?? 0) : 0;

            $pressureRow[$monthDay->format('d.m.Y')] = [
                'value' => $waterInj ? $waterInj['pressure'] : 0,
                'is_editable' => true,
                'params' => [
                    'field' => 'pressure_inj',
                    'date' => $monthDay->format('d.m.Y')
                ]
            ];
            $waterInjRow[$monthDay->format('d.m.Y')] = [
                'value' => $waterInj ? $waterInj['water_inj'] : 0,
                'is_editable' => true,
                'params' => [
                    'field' => 'water_inj_val',
                    'date' => $monthDay->format('d.m.Y')
                ]
            ];
            $workTimeRow[$monthDay->format('d.m.Y')] = ['value' => $dailyWorkTime];

            $monthDay = $monthDay->addDay();
        }

        return [$pressureRow, $waterInjRow, $workTimeRow, []];
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
        $date = Carbon::parse($this->request->get('params')['date'], 'Asia/Almaty')->toImmutable();
        if (in_array($field, ['pressure_inj', 'water_inj_val'])) {
            $pressure = DB::connection('tbd')
                ->table('prod.meas_water_inj')
                ->where('well', $this->request->get('well_id'))
                ->where('dbeg', $date->startOfDay())
                ->first();

            if (empty($pressure)) {
                DB::connection('tbd')
                    ->table('prod.meas_water_inj')
                    ->insert(
                        [
                            'dbeg' => $date->startOfDay(),
                            'dend' => $date->endOfDay(),
                            'well' => $this->request->get('well_id'),
                            $field => $params['value']
                        ]
                    );
                return;
            }

            DB::connection('tbd')
                ->table('prod.meas_water_inj')
                ->where('id', $pressure->id)
                ->update(
                    [
                        $field => $params['value']
                    ]
                );
        }
    }
}