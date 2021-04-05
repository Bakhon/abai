<?php

namespace App\Observers;

use App\Models\ComplicationMonitoring\OmgNGDU;

class OmgNGDUHistoryObserver extends EditHistoryObserver
{
    public function updated(OmgNGDU $omgNGDU)
    {
        $payload = $this->generatePayload($omgNGDU);
        $this->save($omgNGDU, $payload);
    }

    private function generatePayload(OmgNGDU $omgNGDU): array
    {
        $original = $omgNGDU->getOriginal();
        $changes = $omgNGDU->getChanges();

        $history = [];
        $fields = [
            'field_id' => 'monitoring.field',
            'ngdu_id' => 'monitoring.ngdu',
            'cdng_id' => 'monitoring.cdng',
            'gu_id' => 'monitoring.gu',
            'zu_id' => 'monitoring.zu',
            'well_id' => 'monitoring.well',
            'date' => 'app.date_time',
            'daily_fluid_production' => 'monitoring.omgngdu.fields.daily_fluid_production',
            'surge_tank_pressure' => 'monitoring.omgngdu.fields.surge_tank_pressure',
            'pump_discharge_pressure' => 'monitoring.omgngdu.fields.pump_discharge_pressure',
            'heater_inlet_temperature' => 'monitoring.omgngdu.fields.heater_inlet_temperature',
            'daily_gas_production_in_sib' => 'monitoring.omgngdu.fields.daily_gas_production_in_sib',
            'bsw' => 'monitoring.omgngdu.fields.bsw',
            'daily_oil_production' => 'monitoring.omgngdu.fields.daily_oil_production',
            'heater_output_temperature' => 'monitoring.omgngdu.fields.heater_output_temperature',
            'daily_water_production' => 'monitoring.omgngdu.fields.daily_water_production',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'field_id':
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
