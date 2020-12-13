<?php

namespace App\Observers;

use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\WaterMeasurement;

class OilGasHistoryObserver extends EditHistoryObserver
{
    public function updated(OilGas $oilGas)
    {
        $payload = $this->generatePayload($oilGas);
        $this->save($oilGas, $payload);
    }

    private function generatePayload(OilGas $oilGas): array
    {
        $original = $oilGas->getOriginal();
        $changes = $oilGas->getChanges();

        $history = [];
        $fields = [
            'other_objects_id' => 'Прочие объекты',
            'ngdu_id' => 'НГДУ',
            'cdng_id' => 'ЦДНГ',
            'gu_id' => 'ГУ',
            'zu_id' => 'ЗУ',
            'well_id' => 'Скважина',
            'date' => 'Дата и время',
            'water_density_at_20' => 'Плотность нефти при 20°С, кг/м3',
            'oil_viscosity_at_20' => 'Вязкость нефти при 20°С, мм2/с',
            'oil_viscosity_at_40' => 'Вязкость нефти при 40°С, мм2/с',
            'oil_viscosity_at_50' => 'Вязкость нефти при 50°С, мм2/с',
            'oil_viscosity_at_60' => 'Вязкость нефти при 60°С, мм2/с',
            'hydrogen_sulfide_in_gas' => 'H2S в газе, ppm',
            'oxygen_in_gas' => 'О2 в газе, %',
            'carbon_dioxide_in_gas' => 'CO2 в газе, %',
            'gas_density_at_20' => 'Плотность газа при 20°С, кг/м3',
            'gas_viscosity_at_20' => 'Вязкость газа при 20°С, сП',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'other_objects_id':
                case 'ngdu_id':
                case 'cdng_id':
                case 'gu_id':
                case 'zu_id':
                case 'well_id':
                    $classname = self::$classNames[$field];
                    $oldValue = $original[$field] ? $classname::find($original[$field])->name : null;
                    $newValue = isset($changes[$field]) ? $classname::find(
                        $changes[$field]
                    )->name : $oldValue;
                    break;
                default:
                    $oldValue = $original[$field];
                    $newValue = array_key_exists($field, $changes) ? $changes[$field] : $oldValue;
            }

            $history[] = [
                'name' => $name,
                'old' => $oldValue,
                'new' => $newValue,
                'changed' => $oldValue !== $newValue
            ];
        }

        return $history;
    }
}
