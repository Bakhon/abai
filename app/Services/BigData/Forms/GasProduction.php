<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GasProduction extends MeasurementLogForm
{
    protected $configurationFileName = 'gas_production';

    public function getRows(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));

        $wellsQuery = Well::query()
            ->with('techs', 'geo')
            ->select('id', 'uwi')
            ->orderBy('uwi')
            ->active(Carbon::parse($filter->date));


        if ($this->request->get('type') === 'tech') {
            $tech = Tech::find($this->request->get('id'));
            $wellsQuery->whereHas(
                'techs',
                function ($query) use ($tech, $filter) {
                    return $query
                        ->where('dict.tech.id', $tech->id)
                        ->whereDate('dict.tech.dbeg', '<=', $filter->date)
                        ->whereDate('dict.tech.dend', '>=', $filter->date);
                }
            );
        } else {
            $wellsQuery->where('id', $this->request->get('id'));
        }

        if (isset($params['filter']['row_id'])) {
            $wellsQuery->where('id', $params['filter']['row_id']);
        }

        $wells = $wellsQuery->get();

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($this->request->get('date'))
        );

        $wells->transform(
            function ($item) use ($rowData) {
                $result = [];

                foreach ($this->getFields() as $field) {
                    $fieldValue = $this->getFieldValue($field, $rowData, $item);
                    if (!empty($fieldValue)) {
                        $result[$field['code']] = $fieldValue;
                    }
                }
                return $result;
            }
        );

        $this->addLimits($wells);

        return $wells->toArray();
    }


    protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void
    {
        $column = $this->getFieldByCode($field);

        $item = $this->getFieldRow($column, $wellId, $date);

        if (empty($item)) {
            $data = [
                'well' => $wellId,
                $column['column'] => $value,
                'dbeg' => $date->toDateTimeString()
            ];

            if (!empty($column['additional_filter'])) {
                foreach ($column['additional_filter'] as $key => $val) {
                    $data[$key] = $val;
                }
            }

            DB::connection('tbd')
                ->table($column['table'])
                ->insert($data);
        } else {
            DB::connection('tbd')
                ->table($column['table'])
                ->where('id', $item->id)
                ->update(
                    [
                        $column['column'] => $value
                    ]
                );
        }
    }
}