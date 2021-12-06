<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;

class UndergroundEquipmentRepair extends UndergroundEquipmentInstallation
{

    protected $configurationFileName = 'underground_equipment_repair';

    public function getUpdatedFieldList(int $wellId, array $values): array
    {
        $tabs = $this->params()['tabs'];

        if (isset($values['equip_type'])) {
            $equipType = $values['equip_type']['value'] ?? $values['equip_type'];
            $elements = $this->getElements($equipType);

            $tabs[0]['blocks'][0][0]['items'][] = [
                "code" => "equip",
                "type" => "list",
                "editable" => false,
                "values" => $elements,
                "title" => trans('bd.forms.underground_equipment_installation.equip_element')
            ];
        }
        return $tabs;
    }

    protected function submitForm(): array
    {
        $data = $this->request->all();
        if (!isset($data['id'])) {
            throw new \Exception('Не выбрано оборудование');
        }

        $id = DB::connection('tbd')
            ->table('prod.well_equip_repair')
            ->insertGetId(
                [
                    'well_equip' => $data['id'],
                    'work_info' => $data['work_info'],
                    'repair_date' => $data['repair_date'],
                ]
            );

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }
}