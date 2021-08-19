<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TechWaterWell extends TableForm
{
    protected $configurationFileName = 'tech_water_well';

    public function getRows(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        $params['filter']['well_category'] = ['WTR'];
        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($this->request->get('date'))
        );

        $waterMeasurements = DB::connection('tbd')
            ->table('prod.meas_water_prod')
            ->whereIn('well', $wells->pluck('id')->toArray())
            ->where('dbeg', '<=', Carbon::parse($this->request->get('date')))
            ->where('dbeg', '>=', Carbon::parse($this->request->get('date'))->subYears(10))
            ->get()
            ->groupBy('well')
            ->map(function ($measurements) {
                return [
                    'avg' => round($measurements->avg('water_prod_val'), 2),
                    'sum' => round($measurements->sum('water_prod_val'), 2)
                ];
            });

        $wells->transform(
            function ($item) use ($rowData, $waterMeasurements) {
                $result = [];

                foreach ($this->getFields() as $field) {
                    switch ($field['code']) {
                        case 'avg_water_prev_month':
                            $measurement = $waterMeasurements->get($item->id);
                            $value = !empty($measurement) ? $measurement['avg'] : null;

                            $result[$field['code']] = [
                                'value' => $value
                            ];
                            break;
                        case 'sum_water_prev_month':
                            $measurement = $waterMeasurements->get($item->id);
                            $value = !empty($measurement) ? $measurement['sum'] : null;

                            $result[$field['code']] = [
                                'value' => $value
                            ];
                            break;
                        default:
                            $fieldValue = $this->getFieldValue($field, $rowData, $item);
                            if (!empty($fieldValue)) {
                                $result[$field['code']] = $fieldValue;
                            }
                    }
                }

                $result['id'] = $result['uwi']['id'];
                return $result;
            }
        );

        $this->addLimits($wells);

        return [
            'rows' => $wells->toArray()
        ];
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        $column = $this->getFieldByCode($params['field']);

        $item = $this->getFieldRow($column, $params['wellId'], $params['date']);

        if (empty($item)) {
            $data = [
                'well' => $params['wellId'],
                $column['column'] => $params['value'],
                'dbeg' => $params['date']->toDateTimeString()
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
                        $column['column'] => $params['value']
                    ]
                );
        }
    }
}