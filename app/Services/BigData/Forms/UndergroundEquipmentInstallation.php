<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Illuminate\Support\Facades\DB;

class UndergroundEquipmentInstallation extends PlainForm
{
    const TYPES = [
        'NUM' => 'numeric',
        'INT' => 'numeric',
        'TEXT' => 'text',
        'DICT' => 'list',
    ];

    protected $configurationFileName = 'underground_equipment_installation';

    public function getUpdatedFieldList(int $wellId, array $values): array
    {
        $tabs = $this->params()['tabs'];

        if (isset($values['equip_type'])) {
            $elements = $this->getElements($values['equip_type']);

            $tabs[0]['blocks'][0][0]['items'][] = [
                "code" => "equip_element",
                "type" => "list",
                "values" => $elements,
                "title" => "equip_element"
            ];

            $tabs[0]['blocks'][0][1]['items'] = $this->getEquipParams($values['equip_type']);
        }

        if (isset($values['equip_element'])) {
            $properties = $this->getElements($values['equip_element']);

            $tabs[0]['blocks'][0][0]['items'][] = [
                "code" => "equip_element",
                "type" => "list",
                "values" => $elements,
                "title" => "equip_element",
                "callbacks" => [
                    "updateFieldList" => ""
                ]
            ];
        }

        return $tabs;
    }

    private function getElements($equipType)
    {
        $result = [];
        $elements = DB::connection('tbd')
            ->table('dict.equip_element')
            ->where('equip_type', $equipType)
            ->get();

        $params = DB::connection('tbd')
            ->table('dict.equip_element_param as p')
            ->select('p.element', 'p.value_string', 'p.value_double', 'm.name_ru')
            ->join('dict.metric as m', 'p.metric', 'm.id')
            ->whereIn('p.element', $elements->pluck('id')->toArray())
            ->get();

        foreach ($elements as $element) {
            $elementParams = $params->where('element', $element->id)
                ->map(function ($param) {
                    return $param->name_ru . ': ' . ($param->value_string ?? $param->value_double);
                })
                ->join(', ');
            $result[] = [
                'id' => $element->id,
                'name' => $elementParams
            ];
        }
        return $result;
    }

    private function getEquipParams($equipType)
    {
        $params = DB::connection('tbd')
            ->table('dict.equip_param as p')
            ->select('p.id', 'm.name_ru', 'm.id as metric_id', 'dt.code as param_type')
            ->join('dict.metric as m', 'p.metric', 'm.id')
            ->join('dict.data_type as dt', 'm.data_type', 'dt.id')
            ->where('equip_type', $equipType)
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
                "code" => "param_" . $param->id,
                "type" => self::TYPES[$param->param_type],
                "title" => $param->name_ru
            ];
            if ($param->param_type === 'DICT') {
                $field['values'] = $dictValues->get($param->metric_id);
            }

            $fields[] = $field;
        }
        return $fields;
    }

    protected function submitForm(): array
    {
        $data = $this->request->all();
        if (!isset($data['id'])) {
            $this->insertNewRecord($data);
        } else {
        }
    }

    private function insertNewRecord(array $data)
    {
        $equipType = DB::connection('tbd')
            ->table('dict.equip_type')
            ->select('id')
            ->where('code', 'UNDR')
            ->first();

        $params = $this->getParamsToSubmit($data);
        $wellEquipId = DB::connection('tbd')
            ->table('prod.well_equip')
            ->insertGetId(
                [
                    'dbeg' => $data['date'],
                    'dend' => Well::DEFAULT_END_DATE,
                    'well' => $data['well'],
                    'equip_type' => $data['equip_type'],
                    'equip_element' => $data['equip_element'],
                ]
            );

        foreach ($params as $id => $param) {
            $values = [
                'dbeg' => $data['date'],
                'well_equip' => $wellEquipId,
                'equip_param' => $id,
            ];
            if ($param['type'] === 'text') {
                $values['value_string'] = $param['value'];
            } else {
                $values['value_double'] = $param['value'];
            }

            DB::connection('tbd')
                ->table('prod.well_equip_param')
                ->insertGetId($values);
        }
    }

    private function getParamsToSubmit(array $data)
    {
        $paramValues = [];
        foreach ($data as $key => $value) {
            if (strpos($key, 'param_') !== false) {
                $paramValues[str_replace('param_', '', $key)] = $value;
            }
        }

        $params = DB::connection('tbd')
            ->table('dict.equip_param as p')
            ->select('p.id', 'm.name_ru', 'm.id as metric_id', 'dt.code as param_type')
            ->join('dict.metric as m', 'p.metric', 'm.id')
            ->join('dict.data_type as dt', 'm.data_type', 'dt.id')
            ->whereIn('p.id', array_keys($paramValues))
            ->get();

        $result = [];
        foreach ($params as $param) {
            $result[$param->id] = [
                'value' => $paramValues[$param->id],
                'type' => self::TYPES[$param->param_type]
            ];
        }
        return $result;
    }
}