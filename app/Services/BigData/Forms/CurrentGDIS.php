<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\GdisCurrent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CurrentGDIS extends TableForm
{
    protected $configurationFileName = 'current_g_d_i_s';
    protected $gdisFields = [
        [
            'code' => 'conclusion',
            'params' => [
                'type' => 'dict',
                'dict' => 'gdis_conclusion',
            ]
        ],
        [
            'code' => 'target',
            'params' => [
                'type' => 'text'
            ]
        ],
        [
            'code' => 'device',
            'params' => [
                'type' => 'dict',
                'dict' => 'device'
            ]
        ],
        [
            'code' => 'transcript_dynamogram',
            'params' => [
                'type' => 'text'
            ]
        ],
        [
            'code' => 'note',
            'params' => [
                'type' => 'text'
            ]
        ],
        [
            'code' => 'conclusion_text',
            'params' => [
                'type' => 'text'
            ]
        ],
        [
            'code' => 'file_dynamogram',
            'params' => [
                'type' => 'file'
            ]
        ],
    ];

    protected $metricCodes = [
        'HDN',
        'RZAB',
        'PMAX',
        'PURP',
        'PNS',
        'QJT',
        'QJDM',
        'QJDM',
        'GAZF',
        'KNAP',
        'KPOD',
        'PRIV',
        'RPL',
        'RBUF',
        'RSTA',
        'RZAT',
        'RTR',
        'HSTA',
        'TPL',
        'GISL',
        'KOFP',
        'HZAB',
        'DHP',
        'GDNC',
        'GSMN',
        'RZAT',
        'DNSN',
        'LMM',
        'NMIN',
        'DSPR',
        'DSEL',
        'OBOR'
    ];

    public function getResults(): array
    {
        $measurements = $this->getMeasurements();
        $rows = $this->getRows($measurements);
        $columns = $this->getColumns($measurements);

        return [
            'columns' => $columns,
            'rows' => $rows
        ];
    }

    private function getMeasurements()
    {
        $wellId = $this->request->get('id');

        $dates = GdisCurrent::query()
            ->where('well', $wellId)
            ->select('meas_date')
            ->orderBy('meas_date', 'desc')
            ->distinct()
            ->limit(10)
            ->get();

        if ($dates->isEmpty()) {
            return [
                'rows' => []
            ];
        }
        $oldestDate = $dates->last()->meas_date;

        return GdisCurrent::query()
            ->where('well', $wellId)
            ->where('meas_date', '>=', $oldestDate)
            ->orderBy('meas_date', 'desc')
            ->orderBy('id', 'desc')
            ->with('values', 'values.metricItem')
            ->get()
            ->groupBy(function ($item) {
                return $item->meas_date->format('d.m.Y');
            })
            ->map(function ($items, $date) {
                $result = [
                    'date' => $date
                ];

                foreach ($this->gdisFields as $field) {
                    $item = $items->whereNotNull($field['code'])->first();
                    if (!empty($item)) {
                        $result['fields'][$field['code']] = [
                            'value' => $item->{$field['code']},
                        ];
                        if ($field['params']) {
                            $result['fields'][$field['code']] = array_merge(
                                $result['fields'][$field['code']],
                                $field['params']
                            );
                        }
                    }
                }

                foreach ($items as $item) {
                    foreach ($item->values as $value) {
                        if (in_array($value->metricItem->code, $this->metricCodes)) {
                            $result['metrics'][$value->metricItem->code] = [
                                'value' => $value->value_double ?? $value->value_string
                            ];
                        }
                    }
                }

                return $result;
            });
    }

    private function getRows(Collection $measurements): array
    {
        return array_merge(
            $this->getGdisFieldRows($measurements),
            $this->getGdisMetricRows($measurements),
        );
    }

    public function getGdisFieldRows(Collection $measurements)
    {
        $rows = [];
        foreach ($this->gdisFields as $field) {
            $row = [
                'id' => $this->request->get('id'),
                'value' => [
                    'name' => trans('bd.forms.current_g_d_i_s.' . $field['code'])
                ],
                'last_measure_date' => ['name' => null],
                'last_measure_value' => [
                    'value' => null,
                    'params' => [
                        'type' => 'field',
                        'code' => $field['code']
                    ]
                ],
            ];
            $row['last_measure_value'] = array_merge($row['last_measure_value'], $field['params']);
            foreach ($measurements as $date => $measurement) {
                if (isset($measurement['fields'][$field['code']])) {
                    $row[$date] = $measurement['fields'][$field['code']];
                    if (empty($row['last_measure_value']['value'])) {
                        $row['last_measure_date'] = ['name' => $date];
                        $row['last_measure_value']['value'] = $row[$date]['value'];
                    }
                }
            }

            $rows[] = $row;
        }
        return $rows;
    }

    public function getGdisMetricRows(Collection $measurements)
    {
        $metricNames = Metric::whereIn('code', $this->metricCodes)
            ->pluck('name_ru', 'code')
            ->toArray();

        $rows = [];
        foreach ($this->metricCodes as $code) {
            $row = [
                'id' => $this->request->get('id'),
                'value' => [
                    'name' => $metricNames[$code]
                ],
                'last_measure_date' => ['name' => null],
                'last_measure_value' => [
                    'value' => null,
                    'params' => [
                        'type' => 'metric',
                        'code' => $code
                    ]
                ],
            ];
            foreach ($measurements as $date => $measurement) {
                if (isset($measurement['metrics'][$code])) {
                    $row[$date] = $measurement['metrics'][$code];
                    if (empty($row['last_measure_value']['value'])) {
                        $row['last_measure_date'] = ['name' => $date];
                        $row['last_measure_value']['value'] = $row[$date]['value'];
                    }
                }
            }
            $rows[] = $row;
        }
        return $rows;
    }

    private function getColumns(Collection $measurements): array
    {
        $columns = [
            [
                'code' => 'value',
                'title' => trans('bd.forms.current_g_d_i_s.value'),
                'type' => 'label'
            ],
            [
                'code' => 'last_measure_date',
                'title' => trans('bd.forms.current_g_d_i_s.last_measure_date'),
                'type' => 'label'
            ],
            [
                'code' => 'last_measure_value',
                'title' => trans('bd.forms.current_g_d_i_s.last_measure_value'),
                'type' => 'text',
                'is_editable' => true
            ],
        ];

        foreach ($measurements as $date => $measurement) {
            $columns[] = [
                'code' => $date,
                'title' => $date,
                'type' => 'text',
                'is_editable' => false
            ];
        }

        return $columns;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        $code = $this->request->get('params')['code'];
        $measurement = GdisCurrent::query()
            ->where('well', $params['wellId'])
            ->where('meas_date', $params['date'])
            ->first();

        try {
            DB::connection('tbd')->beginTransaction();

            if (empty($measurement)) {
                $measurement = GdisCurrent::create(
                    [
                        'well' => $params['wellId'],
                        'meas_date' => $params['date']
                    ]
                );
            }

            switch ($this->request->get('params')['type']) {
                case 'field':
                    $measurement->update(
                        [
                            $code => $params['value']
                        ]
                    );
                    break;
                case 'metric':

                    $metric = Metric::where('code', $code)->first();
                    $measurementValue = $measurement->values->where('metric', $metric->id)->first();

                    if (empty($measurementValue)) {
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

                    break;
                default:
                    throw new \Exception('Saving error');
            }
            DB::connection('tbd')->commit();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new \Exception('Saving error');
        }
    }
}