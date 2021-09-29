<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TechModeInj extends TableForm
{
    
    protected $configurationFileName = 'tech_mode_inj';
    protected function getCustomFieldValue(array $field, array $rowData, Model $item): ?array
    {
        if (isset($field['table']) && $field['table'] === 'prod.well_equip_param') {
            $equipParams = $this->equipParams->get($item->id);
            if (empty($equipParams)) {
                return ['value' => null];
            }

            $param = $equipParams->where('code', $field['metric_code'])->first();
            return ['value' => $param ? ($param->value_double ?? $param->value_string) : null];
        }

        switch ($field['code']) {
            case 'worktime':    
                    return $this->getWorktime($item);
            case 'avg_liquid_prev_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['liquid(avg)']] : null;
            case 'avg_pressure_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['wcut(avg)']] : null;
            case 'avg_temp_prev_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['oil(avg)']] : null;
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