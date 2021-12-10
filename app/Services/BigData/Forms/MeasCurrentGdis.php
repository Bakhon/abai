<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\GdisCurrent;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class MeasCurrentGdis extends TableForm
{
    protected $configurationFileName = 'meas_current_gdis';

    public function getResults(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty')->toImmutable();

        $this->wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $rows = $this->getRows($date);


        return [
            'rows' => $rows
        ];
    }

    private function getMeasurements()
    {
        $wellIds = $this->wells->pluck('id')->toArray();
        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date, 'Asia/Almaty')->toImmutable();

        return GdisCurrent::query()
            ->whereIn('well', $wellIds)
            ->where('meas_date', '>', $date->subYear())
            ->where('meas_date', '<=', $date)
            ->orderBy('meas_date', 'desc')
            ->orderBy('id', 'desc')
            ->with('values', 'values.metricItem')
            ->get()
            ->groupBy('well');
    }

    private function getRows(CarbonImmutable $date): array
    {
        $measurements = $this->getMeasurements();
        $metrics = $this->getMetrics();
        $columns = $this->getFields();

        return $this->wells
            ->map(
                function ($well) use ($date, $columns, $measurements, $metrics) {
                    $wellMeasurements = $measurements->get($well->id);

                    $result = [
                        'id' => $well->id
                    ];

                    foreach ($columns as $column) {
                        $result[$column['code']] = [
                            'value' => null
                        ];

                        if ($column['code'] === 'uwi') {
                            $result[$column['code']] = [
                                'id' => $well->id,
                                'name' => $well->uwi,
                                'href' => route('bigdata.well_card', ['wellId' => $well->id, 'wellName' => $well->uwi])
                            ];
                            continue;
                        }

                        if (isset($column['table']) && $column['table'] === 'prod.gdis_current_value') {
                            $result[$column['code']]['params'] = [
                                'code' => $column['additional_filter']['metric']['fields']['code']
                            ];
                        }

                        if (!$wellMeasurements) {
                            continue;
                        }

                        if (isset($column['table']) && $column['table'] === 'prod.gdis_current_value') {
                            foreach ($wellMeasurements as $wellMeasurement) {
                                $metric = $metrics->firstWhere(
                                    'code',
                                    $column['additional_filter']['metric']['fields']['code']
                                );
                                if (!$metric) {
                                    continue;
                                }

                                $measurementValue = $wellMeasurement->values->where('metric', $metric->id)->first();
                                if (!empty($measurementValue)) {
                                    $value = $measurementValue->value_string ?? $measurementValue->value_double;

                                    if ($date->diffInDays($wellMeasurement->meas_date) > 0) {
                                        $result[$column['code']]['old_value'] = $value;
                                        $result[$column['code']]['date'] = $wellMeasurement->meas_date;
                                    } else {
                                        $result[$column['code']]['value'] = $value;
                                    }
                                    continue 2;
                                }
                            }

                            $result[$column['code']]['value'] = '';
                            continue;
                        }

                        foreach ($wellMeasurements as $wellMeasurement) {
                            if (!empty($wellMeasurement->{$column['code']})) {
                                $value = $wellMeasurement->{$column['code']};
                                if (empty($value)) {
                                    continue;
                                }

                                if ($date->diffInDays($wellMeasurement->meas_date) > 0) {
                                    $result[$column['code']] = [
                                        'old_value' => $value,
                                        'date' => $wellMeasurement->meas_date
                                    ];
                                } else {
                                    $result[$column['code']] = [
                                        'value' => $value,
                                        'params' => [
                                            'id' => $wellMeasurement->id
                                        ]
                                    ];
                                }
                                continue 2;
                            }
                        }

                        $result[$column['code']] = [
                            'value' => ''
                        ];
                    }
                    return $result;
                }
            )
            ->filter()
            ->values()
            ->toArray();
    }

    public function submitForm(array $rows, array $filter = []): array
    {
        $date = Carbon::parse($filter['date'], 'Asia/Almaty')->toImmutable();
        foreach ($rows as $wellId => $row) {
            foreach ($row as $columnCode => $field) {
                $column = $this->getFields()->where('code', $columnCode)->first();
                if (isset($column['table']) && $column['table'] === 'prod.gdis_current_value') {
                    $measurement = GdisCurrent::where('well', $wellId)
                        ->where('meas_date', $date)
                        ->first();
                    if (!$measurement) {
                        $measurement = GdisCurrent::create(
                            [
                                'well' => $wellId,
                                'meas_date' => $date
                            ]
                        );
                    }
                    $metric = Metric::where('code', $field['params']['code'])->first();
                    if (!$metric) {
                        continue;
                    }
                    $measurementValue = $measurement->values->where('metric', $metric->id)->first();
                    if (!$measurementValue) {
                        $measurementValue = $measurement->values()->create(
                            [
                                'metric' => $metric->id
                            ]
                        );
                    }
                    $measurementValue->update(
                        [
                            'value_string' => $field['value']
                        ]
                    );
                } else {
                    if (isset($field['params']['id'])) {
                        $measurement = GdisCurrent::find($field['params']['id']);
                    } else {
                        $measurement = GdisCurrent::create(
                            [
                                'well' => $wellId,
                                'meas_date' => $date
                            ]
                        );
                    }
                    $measurement->update(
                        [
                            $columnCode => $field['value']
                        ]
                    );
                }
            }
        }

        return [];
    }

    private function getMetrics()
    {
        $metricCodes = $this->getFields()
            ->filter(function ($field) {
                return isset($field['table']) && $field['table'] === 'prod.gdis_current_value';
            })
            ->map(function ($field) {
                return $field['additional_filter']['metric']['fields']['code'];
            })
            ->toArray();

        return Metric::whereIn('code', $metricCodes)->get();
    }

}