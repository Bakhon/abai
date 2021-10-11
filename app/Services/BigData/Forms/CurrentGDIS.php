<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\GdisCurrent;
use App\Services\AttachmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
            'code' => 'conclusion',
            'params' => [
                'type' => 'dict',
                'dict' => 'gdis_conclusion',
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
        'TBP',
        'OTP',
        'OTPM',
        'STLV',
        'FLVL',
        'BHP',
        'RP',
        'RRP',
        'MLP',
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
    ];

    protected $fieldsOrder = [
        'target',
        'device',
        'conclusion',
        'transcript_dynamogram',
        'TBP',
        'OTP',
        'OTPM',
        'STLV',
        'FLVL',
        'BHP',
        'RP',
        'RRP',
        'MLP',
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
        if ($this->request->get('type') !== 'well') {
            //todo: сделать универсальные сообщения, в которые будут передаваться типы объектов
            throw new \Exception(trans('bd.select_well'));
        }

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
            return collect();
        }
        $oldestDate = $dates->last()->meas_date;

        $gdisCurrent = GdisCurrent::query()
            ->where('well', $wellId)
            ->where('meas_date', '>=', $oldestDate)
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
                'id' => $this->request->get('id'),
                'code' => $field['code'],
                'value' => [
                    'name' => trans('bd.forms.current_g_d_i_s.' . $field['code'])
                ],
                'last_measure_date' => ['name' => null],
                'last_measure_value' => [
                    'value' => $field['params']['type'] === 'file' ? [] : null,
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
                'code' => $code,
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

    protected function uploadFile(array $row, array $column, array $filter)
    {
        $date = Carbon::parse($filter['date'], 'Asia/Almaty');
        $query = [
            'origin' => 'dynamogramm',
            'user_id' => auth()->id(),
        ];
        $files = json_decode($this->attachmentService->upload($this->request->uploads, $query));

        $measurement = GdisCurrent::query()
            ->where('well', $row['id'])
            ->where('meas_date', $date)
            ->first();

        if (empty($measurement)) {
            GdisCurrent::create(
                [
                    'well' => $row['id'],
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