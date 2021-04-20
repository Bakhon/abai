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
            'other_objects_id' => 'monitoring.field',
            'ngdu_id' => 'monitoring.ngdu',
            'cdng_id' => 'monitoring.cdng',
            'gu_id' => 'monitoring.gu.gu',
            'zu_id' => 'monitoring.zu.zu',
            'well_id' => 'monitoring.well.well',
            'date' => 'app.date_time',
            'water_density_at_20' => 'monitoring.oil.fields.water_density_at_20',
            'oil_viscosity_at_20' => 'monitoring.oil.fields.oil_viscosity_at_20',
            'oil_viscosity_at_40' => 'monitoring.oil.fields.oil_viscosity_at_40',
            'oil_viscosity_at_50' => 'monitoring.oil.fields.oil_viscosity_at_50',
            'oil_viscosity_at_60' => 'monitoring.oil.fields.oil_viscosity_at_60',
            'hydrogen_sulfide_in_gas' => 'monitoring.oil.fields.hydrogen_sulfide_in_gas',
            'oxygen_in_gas' => 'monitoring.oil.fields.oxygen_in_gas',
            'carbon_dioxide_in_gas' => 'monitoring.oil.fields.carbon_dioxide_in_gas',
            'gas_density_at_20' => 'monitoring.oil.fields.gas_density_at_20',
            'gas_viscosity_at_20' => 'monitoring.oil.fields.gas_viscosity_at_20',
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
