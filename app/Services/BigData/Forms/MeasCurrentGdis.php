<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Models\BigData\Dictionaries\Metric;
use App\Models\BigData\GdisCurrent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        $columns = $this->getColumns($date);


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

    private function getRows(CarbonImmutable $date): array
    {
        $wellIds = $this->wells->pluck('id')->toArray();
        $measurements = $this->getMeasurements();
        $conclusion = $this->getColumn($wellIds, $date, 'conclusion');
        $note = $this->getColumn($wellIds, $date, 'note');
        $device = $this->getDevice($wellIds, $date, 'device');
        $transcript_dynamogram = $this->getColumn($wellIds, $date, 'transcript_dynamogram');
        $target = $this->getColumn($wellIds, $date, 'target');
        $conclusion_text = $this->getColumn($wellIds, $date, 'target');
        
        $rows[] = [
            'conclusion' => $conclusion,
            'note' =>  $note,
            'device' => $device,
            'transcript_dynamogram' => $transcript_dynamogram,
            'target'=>  $target,
            'conclusion_text' => $conclusion_text
        ];
       
        return $rows;
    }

    public function getColumn($wellId,CarbonImmutable $date, string $item){
        return GdisCurrent::query()
            ->where('well', $wellId)
            ->select($item)
            // ->orderBy('meas_date', 'desc')
            ->distinct()            
            // ->groupBy('well')        
            ->get();
    }

    public function getDevice($wellId,CarbonImmutable $date, string $item){
        return GdisCurrent::query()
            ->where('well', $wellId)
            ->select('d.name_ru')
            ->distinct()
            // ->orderBy('meas_date', 'desc')
            ->join('dict.device as d', $item , 'd.id')
            // ->groupBy('well')           
            ->get();
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

    private function getColumns(CarbonImmutable $date): array
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