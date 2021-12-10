<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class UndergroundEquipmentElement extends UndergroundEquipmentInstallation
{

    protected $configurationFileName = 'underground_equipment_element';

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
        }
        return $tabs;
    }
}