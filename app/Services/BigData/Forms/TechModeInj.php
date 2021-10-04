<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Helpers\WorktimeHelper;
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
        $params['filter']['well_category'] = ['INJ'];
        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $tables = $this->getFields()
            ->pluck('table')
            ->filter(function ($table) {
                return !empty($table);
            })
            ->unique();

        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($filter->date)
        );

        $this->oilMeasurements = DB::connection('tbd')
            ->table('prod.meas_water_inj')
            ->whereIn('well', $wells->pluck('id')->toArray())
            ->where('dbeg', '>=', Carbon::parse($filter->date)->subMonthNoOverflow()->firstOfMonth())
            ->where('dbeg', '<=', Carbon::parse($filter->date)->subMonthNoOverflow()->lastOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($measurements) {
                return [
                    'avg(water_inj_val)' => round($measurements->avg('water_inj_val'), 2),
                    'sum(water_inj_val)' => round($measurements->sum('water_inj_val'), 2),
                    'avg(pressure_inj)' => round($measurements->avg('pressure_inj'), 2),
                    'avg(agent_temperature)' => round($measurements->avg('agent_temperature'), 2),
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
            case 'avg(pressure_inj)':
            case 'avg(agent_temperature)':
            case 'avg(water_inj_val)':
            case 'sum(water_inj_val)':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement[$field['code']]] : null;
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
        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty')->toImmutable();
        $startOfDay = $date->startOfDay();
        $endOfDay = $date->endOfDay();

        $wellStatuses = DB::connection('tbd')
            ->table('prod.well_status as s')
            ->select('s.status', 's.dbeg', 's.dend')
            ->join('dict.well_status_type', 'dict.well_status_type.id', 's.status')
            ->where('dbeg', '<=', $endOfDay)
            ->where('dend', '>=', $startOfDay)
            ->where('well', $well->id)
            ->where('dict.well_status_type.code', 'WRK')
            ->get()
            ->map(
                function ($item) {
                    $item->dbeg = Carbon::parse($item->dbeg);
                    $item->dend = Carbon::parse($item->dend);
                    return $item;
                }
            );

        $hours = WorktimeHelper::getHoursForOneDay($wellStatuses, $startOfDay, $endOfDay, $well->id);

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
    }

}