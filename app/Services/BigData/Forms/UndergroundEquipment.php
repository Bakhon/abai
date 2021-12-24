<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UndergroundEquipment extends PlainForm
{
    const TYPES = [
        'NUM' => 'numeric',
        'INT' => 'numeric',
        'TEXT' => 'text',
        'DICT' => 'list',
    ];

    protected $configurationFileName = 'underground_equipment';

    protected function getRows(): Collection
    {
        $rows = parent::getRows();

        $equips = DB::connection('tbd')
            ->table('dict.equip as e')
            ->select('e.id', 'e.vendor_code', 'et.name_ru as type_name', 'et.id as type_id')
            ->join('dict.equip_type as et', 'e.equip_type', 'et.id')
            ->whereIn('e.id', $rows->pluck('equip')->toArray())
            ->get();

        $equipTypeIds = $equips->pluck('type_id')->unique()->toArray();
        $params = collect($this->getEquipParams($equipTypeIds));

        $paramValues = DB::connection('tbd')
            ->table('prod.well_equip_param')
            ->whereIn('well_equip', $rows->pluck('id')->toArray())
            ->get();

        return $rows->map(function ($row) use ($equips, $params, $paramValues) {
            $equip = $equips->where('id', $row->equip)->first();
            $rowParamValues = $paramValues->where('well_equip', $row->id);
            return $this->formatRow($row, $equip, $params, $rowParamValues);
        });
    }

    protected function formatRow($row, $equip, Collection $params, Collection $rowParamValues)
    {
        $row->equip_type = [
            'value' => $equip->type_id,
            'formated_value' => $equip->type_name
        ];
        $row->equip = [
            'value' => [
                'id' => $equip->id,
                'name' => $equip->vendor_code
            ],
            'formated_value' => $equip->vendor_code
        ];

        if ($row->dend) {
            $dbeg = Carbon::parse($row->dbeg, 'Asia/Almaty')->format('d.m.Y');
            $dend = Carbon::parse($row->dend, 'Asia/Almaty')->format('d.m.Y');
            $row->dbeg = [
                'value' => $row->dbeg,
                'formated_value' => "{$dbeg} - {$dend}"
            ];
        }

        $equipParams = [];
        foreach ($rowParamValues as $rowParamValue) {
            $param = $params->where('param_id', $rowParamValue->equip_param)->first();
            $value = $rowParamValue->value_double ?? $rowParamValue->value_string;
            if (empty($param)) {
                continue;
            }
            if ($param['type'] === 'list') {
                $paramValue = collect($param['values'])->where('id', $value)->first();
                $value = $paramValue['name'];
                $row->{$param['code']} = [
                    'value' => $paramValue,
                    'formated_value' => $value
                ];
            } else {
                $row->{$param['code']} = $value;
            }
            $equipParams[] = "<span style='white-space: nowrap'>{$param['title']}: {$value}</span>";
        }
        $row->equip_params = implode('<br>', $equipParams);

        return $row;
    }

    protected function getEquipParams(array $equipType): array
    {
        $params = DB::connection('tbd')
            ->table('dict.equip_param as p')
            ->select('p.id', 'm.name_ru', 'm.id as metric_id', 'dt.code as param_type')
            ->join('dict.metric as m', 'p.metric', 'm.id')
            ->join('dict.data_type as dt', 'm.data_type', 'dt.id')
            ->whereIn('equip_type', $equipType)
            ->get();

        $dictMetricIds = $params->where('param_type', 'DICT')->pluck('metric_id')->toArray();

        $dictValues = DB::connection('tbd')
            ->table('dict.equip_param_dict')
            ->whereIn('param_source', $dictMetricIds)
            ->get()
            ->groupBy('param_source')
            ->map(function ($items) {
                $values = [];
                foreach ($items as $item) {
                    $values[] = [
                        'id' => $item->id,
                        'name' => $item->value_string ?? $item->value_double
                    ];
                }
                return $values;
            });

        $fields = [];

        foreach ($params as $param) {
            $field = [
                'param_id' => $param->id,
                'code' => 'param_' . $param->id,
                'type' => self::TYPES[$param->param_type],
                'title' => $param->name_ru
            ];
            if ($param->param_type === 'DICT') {
                $field['values'] = $dictValues->get($param->metric_id);
            }

            $fields[] = $field;
        }
        return $fields;
    }
}