<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Jobs\RunPostgresqlProcedure;
use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\GdisCurrent;
use App\Services\AttachmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CurrentGDIS extends TableForm
{
    protected $configurationFileName = 'current_g_d_i_s';
    protected $gdisFields = [
        [
            'code' => 'target',
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
        'FLVL',
        'STLV',
        'BHP',
        'RP',
        'BP',
        'STP',
        'RSVT',
        'INJR',
        'FLRT',
        'FLRD',
        'GASR',
        'ADMCF',
        'PDCF',
        'RSD',
        'PRDK',
        'DBD',
        'SLHDM',
        'PSHDM',
        'PSD',
        'TPDM',
        'PLST',
        'PMPR',
        'SHDMD',
        'SHDME',
        'RPM',
        'WCUT',
        'PINT',
        'PFLL'
    ];

    protected $fieldsOrder = [
        'target',
        'FLVL',
        'STLV',
        'OTP',
        'BP',
        'PINT',
        'PFLL',
        'BHP',
        'RP',
        'BP',
        'OTP',
        'PSD',
        'conclusion',
        'device',
        'transcript_dynamogram',
        'note',
        'conclusion_text',
        'file_dynamogram'
    ];

    protected $attachmentService;

    public function __construct(Request $request)
    {
        $this->attachmentService = app()->make(AttachmentService::class);
        parent::__construct($request);
    }

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

        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date, 'Asia/Almaty')->toImmutable();

        $dates = GdisCurrent::query()
            ->where('well', $wellId)
            ->select('meas_date')
            ->where('meas_date', '<=', $date)
            ->orderBy('meas_date', 'desc')
            ->distinct()
            ->limit(10)
            ->get();

        if ($dates->isEmpty()) {
            return collect();
        }
        $oldestDate = $dates->last()->meas_date;

        $gdisCurrent = GdisCurrent::query()
            ->where('well', $wellId)
            ->where('meas_date', '>=', $oldestDate)
            ->where('meas_date', '<=', $date)
            ->orderBy('meas_date', 'desc')
            ->orderBy('id', 'desc')
            ->with('values', 'values.metricItem')
            ->get();

        $files = $this->getFiles($gdisCurrent);

        return $gdisCurrent
            ->groupBy(function ($item) {
                return $item->meas_date->format('d.m.Y');
            })
            ->map(function ($items, $date) use ($files) {
                $result = [
                    'date' => $date
                ];

                foreach ($this->gdisFields as $field) {
                    $item = $items->whereNotNull($field['code'])->first();
                    if (!empty($item)) {
                        $value = $item->{$field['code']};
                        if ($field['code'] === 'file_dynamogram' && $value) {
                            $value = $files->where('id', $value);
                        }

                        $result['fields'][$field['code']] = [
                            'value' => $value,
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
        $result = array_merge(
            $this->getGdisMetricRows($measurements),
            $this->getGdisFieldRows($measurements),
        );

        usort($result, function ($a, $b) {
            return (array_search($a['code'], $this->fieldsOrder) > array_search($b['code'], $this->fieldsOrder));
        });

        return $result;
    }

    public function getGdisFieldRows(Collection $measurements)
    {
        $rows = [];
        foreach ($this->gdisFields as $field) {
            $row = [
                'id' => implode('_', [$this->request->get('id'), 'field', $field['code']]),
                'code' => $field['code'],
                'value' => [
                    'name' => trans('bd.forms.current_g_d_i_s.' . $field['code'])
                ],
                'last_measure_date' => ['name' => null],
                'last_measure_value' => [
                    'value' => $field['params']['type'] === 'file' ? [] : null,
                    'params' => [
                        'type' => 'field',
                        'code' => $field['code'],
                        'well_id' => $this->request->get('id')
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
            ->pluck('name_short_ru', 'code')
            ->toArray();

        $rows = [];
        foreach ($this->metricCodes as $code) {
            if (!isset($metricNames[$code])) {
                continue;
            }
            $row = [
                'id' => implode('_', [$this->request->get('id'), 'metric', $code]),
                'code' => $code,
                'value' => [
                    'name' => $metricNames[$code]
                ],
                'last_measure_date' => ['name' => null],
                'last_measure_value' => [
                    'value' => null,
                    'params' => [
                        'type' => 'metric',
                        'code' => $code,
                        'well_id' => $this->request->get('id')
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

    protected function uploadFile(array $row, array $column, array $filter)
    {
        $date = Carbon::parse($filter['date'], 'Asia/Almaty');
        $wellId = $row['last_measure_value']['params']['well_id'];
        $query = [
            'origin' => 'dynamogramm',
            'user_id' => auth()->id(),
        ];
        $files = $this->attachmentService->upload($this->request->uploads, $query);

        $measurement = GdisCurrent::query()
            ->where('well', $wellId)
            ->where('meas_date', $date)
            ->first();

        if (empty($measurement)) {
            GdisCurrent::create(
                [
                    'well' => $wellId,
                    'meas_date' => $date,
                    $row['code'] => reset($files)
                ]
            );
        } else {
            $measurement->update(
                [
                    $row['code'] => reset($files)
                ]
            );
        }

        return $this->attachmentService->getInfo($files);
    }

    private function getFiles(Collection $gdisCurrent): Collection
    {
        $fileIds = $gdisCurrent->pluck('file_dynamogram')->filter()->toArray();
        if (!empty($fileIds)) {
            return $this->attachmentService->getInfo($fileIds);
        }
        return collect();
    }


    public function submitForm(array $rows, array $filter = []): array
    {
        $date = Carbon::parse($filter['date'], 'Asia/Almaty');
        $wellId = reset($rows)['last_measure_value']['params']['well_id'];
        $measurement = GdisCurrent::query()
            ->where('well', $wellId)
            ->where('meas_date', $date)
            ->first();

        if (empty($measurement)) {
            $measurement = GdisCurrent::create(
                [
                    'well' => $wellId,
                    'meas_date' => $date
                ]
            );
        }

        foreach ($rows as $row) {
            foreach ($row as $field) {
                switch ($field['params']['type']) {
                    case 'field':
                        $measurement->update(
                            [
                                $field['params']['code'] => $field['value']
                            ]
                        );
                        break;
                    case 'metric':

                        $metric = Metric::where('code', $field['params']['code'])->first();
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
                                'value_string' => $field['value']
                            ]
                        );

                        break;
                    default:
                        throw new \Exception('Saving error');
                }
            }
        }

        return [];
    }


    protected function afterSubmit(array $fields, array $filter = [])
    {
        $date = Carbon::parse($filter['date']);
        if ($date->startOfDay() >= Carbon::now()->startOfDay()) {
            return;
        }

        if (!empty($fields)) {
            $field = reset($fields);
            $wellId = $field['last_measure_value']['params']['well_id'];
            RunPostgresqlProcedure::dispatch('dmart.sync_well_daily_prod_oil_abai', [$wellId, $date->format('Y-m-d')]);
        }
    }
}