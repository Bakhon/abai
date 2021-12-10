<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Illuminate\Support\Facades\DB;

class UndergroundEquipmentInstallation extends UndergroundEquipment
{

    protected $configurationFileName = 'underground_equipment_installation';

    public function getUpdatedFieldList(int $wellId, array $values): array
    {
        $tabs = $this->params()['tabs'];

        if (isset($values['equip_type'])) {
            $equipType = $values['equip_type']['value'] ?? $values['equip_type'];
            $elements = $this->getElements($equipType);

            $tabs[0]['blocks'][0][0]['items'][] = [
                "code" => "equip",
                "type" => "list",
                "values" => $elements,
                "title" => trans('bd.forms.underground_equipment_installation.equip_element')
            ];

            $tabs[0]['blocks'][0][1]['items'] = $this->getEquipParams([$equipType]);
        }
        return $tabs;
    }

    protected function getElements(int $equipType): array
    {
        return DB::connection('tbd')
            ->table('dict.equip')
            ->select('id', 'vendor_code as name')
            ->where('equip_type', $equipType)
            ->get()
            ->toArray();
    }

    protected function submitForm(): array
    {
        $data = $this->request->all();
        if (!isset($data['id'])) {
            $id = $this->insertNewRecord($data);
        } else {
            $id = $data['id'];
            $this->updateRecord($data);
        }
        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }

    private function insertNewRecord(array $data)
    {
        $params = $this->getParamsToSubmit($data);

        $wellEquipId = DB::connection('tbd')
            ->table('prod.well_equip')
            ->insertGetId(
                [
                    'dbeg' => $data['dbeg'],
                    'dend' => Well::DEFAULT_END_DATE,
                    'well' => $data['well'],
                    'equip' => $data['equip'] ? $data['equip']['id'] : null
                ]
            );

        foreach ($params as $id => $param) {
            $values = [
                'dbeg' => $data['dbeg'],
                'well_equip' => $wellEquipId,
                'equip_param' => $id,
            ];

            $value = is_array($param['value']) ? $param['value']['id'] : $param['value'];

            if ($param['type'] === 'text') {
                $values['value_string'] = $value;
            } else {
                $values['value_double'] = $value;
            }

            DB::connection('tbd')
                ->table('prod.well_equip_param')
                ->insertGetId($values);
        }

        return $wellEquipId;
    }

    private function updateRecord(array $data)
    {
        $params = $this->getParamsToSubmit($data);
        $wellEquipId = $data['id'];

        DB::connection('tbd')
            ->table('prod.well_equip')
            ->where('id', $data['id'])
            ->update(
                [
                    'dbeg' => $data['dbeg'],
                    'well' => $data['well'],
                    'equip' => $data['equip'] ? $data['equip']['id'] : null
                ]
            );

        $existingParams = DB::connection('tbd')
            ->table('prod.well_equip_param')
            ->where('well_equip', $wellEquipId)
            ->get();

        foreach ($params as $id => $param) {
            $existingParam = $existingParams->where('well_equip', $wellEquipId)
                ->where('equip_param', $id)
                ->first();

            $values = [];
            if (!$existingParam) {
                $values = [
                    'dbeg' => $data['dbeg'],
                    'well_equip' => $wellEquipId,
                    'equip_param' => $id,
                ];
            }

            $value = is_array($param['value']) ? $param['value']['id'] : $param['value'];

            if ($param['type'] === 'text') {
                $values['value_string'] = $value;
            } else {
                $values['value_double'] = $value;
            }

            if ($existingParam) {
                DB::connection('tbd')
                    ->table('prod.well_equip_param')
                    ->where('id', $existingParam->id)
                    ->update($values);
            } else {
                DB::connection('tbd')
                    ->table('prod.well_equip_param')
                    ->insertGetId($values);
            }
        }

        return $wellEquipId;
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