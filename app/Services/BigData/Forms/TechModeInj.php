<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TechModeInj extends TableForm
{
    
    protected $configurationFileName = 'tech_mode_inj';
    protected $oilMeasurements;

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));
        $params['filter']['well_category'] = ['OIL', 'GAS'];
        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $tables = $this->getFields()
            ->pluck('table')
            ->filter(function ($table) {
                if (empty($table)) {
                    return false;
                }
            })
            ->unique();

        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($this->request->get('date'))
        );

        $this->oilMeasurements = DB::connection('tbd')
            ->table('prod.tech_mode_inj')
            ->whereIn('well', $wells->pluck('id')->toArray())
            ->where('dbeg', '<=', Carbon::parse($this->request->get('date'))->subMonthNoOverflow()->firstOfMonth())
            ->where('dbeg', '>=', Carbon::parse($this->request->get('date'))->subMonthNoOverflow()->lastOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($measurements) {
                return [
                    'liquid(avg)' => round($measurements->avg('liquid'), 2),
                    'pressure(avg)' => round($measurements->avg('pressure'), 2),
                    'temp(avg)' => round($measurements->avg('temp'), 2)
                ];
            });

        
        $wells->transform(
            function ($item) use ($rowData) {
                $result = [];

                foreach ($this->getFields() as $field) {
                    $value = $this->getFieldValue($field, $rowData, $item);
                    if (!empty($value)) {
                        $result[$field['code']] = $value;
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
    protected function getCustomFieldValue(array $field, array $rowData, Model $item): ?array
    {      

        switch ($field['code']) {
            case 'worktime':    
                return $this->getWorktime($item);
            case 'avg_liquid_prev_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['liquid(avg)']] : null;
            case 'avg_pressure_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['pressure(avg)']] : null;
            case 'avg_temp_prev_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['temp(avg)']] : null;
            case 'events':
                return DB::connection('tbd')
                    ->table('prod.tech_mode_event')
                    ->select('id', 'event_type', 'plan_month')
                    ->where('well', $item->id)
                    ->get()
                    ->toArray();
            default:
                return null;
        }
    }

    private function getWorktime(Model $well)
    {
        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty');
        $startOfDay = clone ($date)->startOfDay();
        $endOfDay = clone ($date)->endOfDay();

        $wellStatuses = DB::connection('tbd')
            ->table('prod.well_status as s')
            ->select('s.status', 's.dbeg', 's.dend')
            ->join('dict.well_status_type', 'dict.well_status_type.id', 's.status')
            ->where('dbeg', '<=', $endOfDay)
            ->where('dend', '>=', $startOfDay)
            ->where('well', $well->id)
            ->whereIn('dict.well_status_type.code', 'WRK')
            ->get()
            ->map(
                function ($item) {
                    $item->dbeg = Carbon::parse($item->dbeg);
                    $item->dend = Carbon::parse($item->dend);
                    return $item;
                }
            );

        $hours = 0;
        foreach ($wellStatuses as $status) {
            if ($status->dbeg <= $startOfDay && $status->dend >= $endOfDay) {
                $hours += 24;
            } elseif ($status->dbeg > $startOfDay) {
                $hours += $status->dbeg->diffInHours($status->dend < $endOfDay ? $status->dend : $endOfDay);
            } elseif ($status->dend < $endOfDay) {
                $hours += $startOfDay->diffInHours($status->dend);
            }
        }

        return [
            'value' => $hours
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
                'dbeg' => $params['date']->toDateTimeString(),
                'dend' => Well::DEFAULT_END_DATE
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

        $field = $this->request->get('params')['field'];
        $date = $this->request->get('params')['date'];
        if ($field === 'water_inj_val') {
            $pressure = DB::connection('tbd')
                ->table('prod.meas_water_inj')
                ->where('dbeg', Carbon::parse($date))
                ->where('well', $this->request->get('well_id'))
                ->first();

            if (empty($pressure)) {
                DB::connection('tbd')
                    ->table('prod.meas_water_inj')
                    ->insert(
                        [
                            'dbeg' => Carbon::parse($date),
                            'dend' => Well::DEFAULT_END_DATE,
                            'well' => $this->request->get('well_id'),
                            'water_inj_val' => $params['value']
                        ]
                    );
                return;
            }

            DB::connection('tbd')
                ->table('prod.meas_water_inj')
                ->where('id', $pressure->id)
                ->update(
                    [
                        'pressure_inj' => $params['value']
                    ]
                );
        }
    }
    
}