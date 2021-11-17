<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WaterProductionMonth extends MeasLogByMonth
{
    protected $configurationFileName = 'water_production_month';

    public function getResults(array $params = []): array
    {
        if ($this->request->get('type') !== 'tech') {
            throw new \Exception(trans('bd.select_gu'));
        }

        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty')->toImmutable();

        $params['filter']['well_category'] = ['WTR'];
        $this->wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $rows = $this->getRows($date, $this->wells);
        $columns = $this->getColumns($date);


        return [
            'columns' => $columns,
            'rows' => $rows
        ];
    }

    protected function getRows(CarbonImmutable $date, Collection $wells): array
    {
        $wellIds = $this->wells->pluck('id')->toArray();
        $workTimes = $this->getWorkTime($wellIds, $date);
        $waterProdVal = $this->getWaterProdVal($wellIds, $date);

        $indicators = [
            'water_prod_val',
            'worktime',
            'water_val'
        ];
        $rows = [];
        foreach ($wells as $well) {
            $rows = array_merge($rows, $this->getWellRows($well, $date, $waterProdVal, $workTimes));
        }
        return $rows;
    }


    private function getWaterProdVal(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.meas_water_prod as mwi')
            ->select('mwi.well', 'mwi.water_prod_val', 'mwi.dbeg')
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
                    return round((int)$item->water_prod_val, 2);
                });
            });
    }


    private function getWellRows(
        Well $well,
        CarbonImmutable $date,
        Collection $water,
        array $workTimes
    ) {
        $waterRow = [
            'id' => $well->id,
            'uwi' => ['value' => $well->uwi],
            'indicator' => ['value' => trans('bd.forms.water_production_month.water_prod_val')]
        ];
        $workTimeRow = [
            'id' => $well->id,
            'indicator' => ['value' => trans('bd.forms.water_production_month.worktime')]
        ];
        $waterSumRow = [
            'id' => $well->id,
            'indicator' => ['value' => trans('bd.forms.water_production_month.water_val')]
        ];

        $workTime = $workTimes[$well->id] ?? null;

        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $water_prod_val = $water->get($well->id) ? $water->get($well->id)->get($monthDay->format('j')) : 0;
            $dailyWorkTime = $workTime ? ($workTime[$monthDay->format('j')]['value'] ?? 0) : 0;
            $waterRow[$monthDay->format('d.m.Y')] = [
                'value' => $water_prod_val,
                'is_editable' => true,
                'params' => [
                    'well_id' => $well->id,
                    'indicator' => 'water_prod_val',
                    'date' => $monthDay->format('d.m.Y')
                ]
            ];
            $waterSumRow[$monthDay->format('d.m.Y')] = ['value' => round($water_prod_val * $dailyWorkTime / 24, 2)];
            $workTimeRow[$monthDay->format('d.m.Y')] = ['value' => $dailyWorkTime];

            $monthDay = $monthDay->addDay();
        }

        return [$waterRow, $waterSumRow, $workTimeRow, []];
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

    public function submitForm(array $rows, array $filter = []): array
    {
        foreach ($rows as $row) {
            foreach ($row as $date => $field) {
                $date = Carbon::parse($date, 'Asia/Almaty')->toImmutable();

                if ($field['params']['indicator'] === 'water_prod_val') {
                    $pressure = DB::connection('tbd')
                        ->table('prod.meas_water_prod')
                        ->where('dbeg', $date)
                        ->where('well', $field['params']['well_id'])
                        ->first();

                    if (empty($pressure)) {
                        DB::connection('tbd')
                            ->table('prod.meas_water_prod')
                            ->insert(
                                [
                                    'dbeg' => Carbon::parse($date),
                                    'dend' => Well::DEFAULT_END_DATE,
                                    'well' => $field['params']['well_id'],
                                    'water_prod_val' => $field['value']
                                ]
                            );
                        continue;
                    }

                    DB::connection('tbd')
                        ->table('prod.meas_water_prod')
                        ->where('id', $pressure->id)
                        ->update(
                            [
                                'water_prod_val' => $field['value']
                            ]
                        );
                }
            }
        }

        return [];
    }

}