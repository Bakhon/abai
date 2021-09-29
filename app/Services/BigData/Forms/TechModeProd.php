<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TechModeProd extends TableForm
{
    protected $configurationFileName = 'tech_mode_prod';
    protected $oilMeasurements;
    protected $equipParams;

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

                return !in_array($table, ['prod.well_equip_param']);
            })
            ->unique();

        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($this->request->get('date'))
        );

        $this->oilMeasurements = DB::connection('tbd')
            ->table('prod.tech_mode_prod_oil')
            ->whereIn('well', $wells->pluck('id')->toArray())
            ->where('dbeg', '<=', Carbon::parse($this->request->get('date'))->subMonthNoOverflow()->firstOfMonth())
            ->where('dbeg', '>=', Carbon::parse($this->request->get('date'))->subMonthNoOverflow()->lastOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($measurements) {
                return [
                    'wcut(avg)' => round($measurements->avg('wcut'), 2),
                    'liquid(avg)' => round($measurements->avg('liquid'), 2),
                    'oil(avg)' => round($measurements->avg('oil'), 2),
                    'sum' => round($measurements->sum('oil'), 2)
                ];
            });

        $this->equipParams = DB::connection('tbd')
            ->table('prod.well_equip_param as wep')
            ->select('we.well', 'wep.value_double', 'wep.value_string', 'm.code')
            ->join('prod.well_equip as we', 'wep.well_equip', 'we.id')
            ->join('dict.equip_param as ep', 'wep.equip_param', 'ep.id')
            ->join('dict.metric as m', 'ep.metric', 'm.id')
            ->whereIn('we.well', $wells->pluck('id')->toArray())
            ->get()
            ->groupBy('well');

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
        if (isset($field['table']) && $field['table'] === 'prod.well_equip_param') {
            $equipParams = $this->equipParams->get($item->id);
            if (empty($equipParams)) {
                return ['value' => null];
            }

            $param = $equipParams->where('code', $field['metric_code'])->first();
            return ['value' => $param ? ($param->value_double ?? $param->value_string) : null];
        }

        switch ($field['code']) {
            case 'avg_liquid_prev_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['liquid(avg)']] : null;
            case 'avg_wcut_prev_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['wcut(avg)']] : null;
            case 'avg_oil_prev_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['oil(avg)']] : null;
            case 'sum_oil_prev_month':
                $measurement = $this->oilMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['sum']] : null;
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

