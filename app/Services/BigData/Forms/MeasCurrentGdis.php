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
    protected $metricCodes = [
        'RTR',
        'RZAT',
        'HSTA',
        'HDN',
        'RPL',
        'RZAB',
        'PMAX',
        'PNS',
        'QJT',
        'QJDM',
        'QJDM',
        'GAZF',
        'KNAP',
        'KPOD',
        'PRIV',
        'RBUF',
        'RSTA',
        'TPL',
        'GISL',
        'KOFP',
        'HZAB',
        'DHP',
        'GDNC',
        'GSMN',
        'DNSN',
        'LMM',
        'NMIN',
        'DSPR',
        'DSEL',
        'OBOR'
    ];

    protected $fieldsOrder = [
        'target',
        'device',
        'conclusion',
        'transcript_dynamogram',
        'RTR',
        'RZAT',
        'HSTA',
        'HDN',
        'RZAB',
        'RPL',
        'PRIV',
        'PMAX',
        'RBUF',
        'RSTA',
        'TPL',
        'PNS',
        'QJT',
        'QJDM',
        'QJDM',
        'GAZF',
        'KNAP',
        'KPOD',
        'GISL',
        'KOFP',
        'HZAB',
        'DHP',
        'GDNC',
        'GSMN',
        'DNSN',
        'LMM',
        'NMIN',
        'DSPR',
        'DSEL',
        'OBOR',
        'note',
        'conclusion_text',
        'file_dynamogram'
    ];


    public function getResults(array $params = []): array
    {
        if ($this->request->get('type') !== 'tech') {
            throw new \Exception(trans('bd.select_gu'));
        }

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
        $date = Carbon::parse($filter->date, 'Asia/Almaty');

        return GdisCurrent::query()
            ->whereIn('well', $wellIds)
            ->where('meas_date', '>', $date->subYear())
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
                        if ($column['code'] === 'uwi') {
                            $result[$column['code']] = [
                                'value' => $well->uwi
                            ];
                            continue;
                        }

                        if (!$wellMeasurements) {
                            $result[$column['code']] = [
                                'value' => null
                            ];
                            continue;
                        }

                        if (isset($column['table']) && $column['table'] === 'prod.gdis_current_value') {
                            $result[$column['code']] = [
                                'params' => [
                                    'code' => $column['additional_filter']['metric']['fields']['code']
                                ]
                            ];

                            foreach ($wellMeasurements as $wellMeasurement) {
                                $metric = $metrics->firstWhere(
                                    'code',
                                    $column['additional_filter']['metric']['fields']['code']
                                );
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

    protected function saveSingleFieldInDB(array $params): void
    {
        $column = $this->getFields()->where('code', $params['field'])->first();
        if (isset($column['table']) && $column['table'] === 'prod.gdis_current_value') {
            $measurement = GdisCurrent::where('well', $params['wellId'])
                ->where('meas_date', $params['date'])
                ->first();
            if (!$measurement) {
                $measurement = GdisCurrent::create(
                    [
                        'well' => $params['wellId'],
                        'meas_date' => $params['date']
                    ]
                );
            }
            $metric = Metric::where('code', $this->request->get('params')['code'])->first();
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
                    'value_string' => $params['value']
                ]
            );
        } else {
            if ($this->request->get('params')) {
                $measurement = GdisCurrent::find($this->request->get('params')['id']);
            } else {
                $measurement = GdisCurrent::create(
                    [
                        'well' => $params['wellId'],
                        'meas_date' => $params['date']
                    ]
                );
            }
            $measurement->update(
                [
                    $params['field'] => $params['value']
                ]
            );
        }
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