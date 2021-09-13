<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\GdisCurrent;
use Illuminate\Support\Collection;

class CurrentGDIS extends TableForm
{
    protected $configurationFileName = 'current_g_d_i_s';
    protected $gdisFields = [
        [
            'code' => 'conclusion',
            'type' => 'dict',
            'dict' => 'gdis_conclusion',
        ],
        [
            'code' => 'target',
            'type' => 'text'
        ],
        [
            'code' => 'device',
            'type' => 'dict',
            'dict' => 'device'
        ],
        [
            'code' => 'transcript_dynamogram',
            'type' => 'text'
        ],
        [
            'code' => 'note',
            'type' => 'text'
        ],
        [
            'code' => 'conclusion_text',
            'type' => 'text'
        ],
        [
            'code' => 'file_dynamogram',
            'type' => 'file'
        ],
    ];

    protected $metricCodes = [
        'FLVL',
        'BHP',
        'MLP',
        'INJR',
        'FLRT',
        'FLRD',
        'WCUT',
        'GASR',
        'ADMCF',
        'PDCF',
        'RRP',
        'RP',
        'BP',
        'STP',
        'OTP',
        'TBP',
        'STLV',
        'RSVT',
        'RSD',
        'PRDK',
        'DBD',
        'SLHDM',
        'PSHDM',
        'PSD',
        'OTPM',
        'TPDM',
        'PLST',
        'PMPR',
        'SHDMD',
        'SHDME',
        'RPM'
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
        $wellId = 1524;

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
                'title' => 'Показатель',
                'type' => 'label'
            ],
            [
                'code' => 'last_measure_date',
                'title' => 'last_measure_date',
                'type' => 'label'
            ],
            [
                'code' => 'last_measure_value',
                'title' => 'last_measure_value',
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
    }
}