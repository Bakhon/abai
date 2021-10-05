<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use App\Models\BigData\Well;
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
            'indicator' => ['value' => trans('bd.forms.meas_water_prod.water_prod_val')]
        ];
        $workTimeRow = [
            'id' => $well->id,
            'uwi' => ['value' => $well->uwi],
            'indicator' => ['value' => trans('bd.forms.meas_water_prod.worktime')]
        ];
        $waterSumRow = [
            'id' => $well->id,
            'uwi' => ['value' => $well->uwi],
            'indicator' => ['value' => trans('bd.forms.meas_water_prod.water_val')]
        ];

        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $water_prod_val = $water->get($well->id) ? $water->get($well->id)->get($monthDay->format('j')) : 0;
            $workTime = $workTimes[$monthDay->format('j')] ?? null;

            $waterRow[$monthDay->format('d.m.Y')] = [
                'value' => $water_prod_val,
                'is_editable' => true,
                'params' => [
                    'field' => 'water_prod_val',
                    'date' => $monthDay->format('d.m.Y')
                ]
            ];
            $waterSumRow[$monthDay->format('d.m.Y')] = ['value' => $water_prod_val * $workTime];
            $workTimeRow[$monthDay->format('d.m.Y')] = ['value' => $workTime ?? 0];

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

    protected function saveSingleFieldInDB(array $params): void
    {
        $field = $this->request->get('params')['field'];
        $date = $this->request->get('params')['date'];
        if ($field === 'water_prod_val') {
            $pressure = DB::connection('tbd')
                ->table('prod.meas_water_prod')
                ->where('dbeg', Carbon::parse($date))
                ->where('well', $this->request->get('well_id'))
                ->first();

            if (empty($pressure)) {
                DB::connection('tbd')
                    ->table('prod.meas_water_prod')
                    ->insert(
                        [
                            'dbeg' => Carbon::parse($date),
                            'dend' => Well::DEFAULT_END_DATE,
                            'well' => $this->request->get('well_id'),
                            'water_prod_val' => $params['value']
                        ]
                    );
                return;
            }

            DB::connection('tbd')
                ->table('prod.meas_water_prod')
                ->where('id', $pressure->id)
                ->update(
                    [
                        'water_prod_val' => $params['value']
                    ]
                );
        }
    }    
    
}