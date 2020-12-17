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
            'field_id' => 'Месторождение',
            'ngdu_id' => 'НГДУ',
            'cdng_id' => 'ЦДНГ',
            'gu_id' => 'ГУ',
            'zu_id' => 'ЗУ',
            'well_id' => 'Скважина',
            'date' => 'Дата и время',
            'daily_fluid_production' => 'Суточная добыча жидкости в ГУ, м3/сут',
            'surge_tank_pressure' => 'Давление в буферной емкости в ГУ, бар',
            'pump_discharge_pressure' => 'Давление на выходе насоса в ГУ, бар',
            'heater_inlet_pressure' => 'Температура на входе в печь в ГУ, С',
            'daily_gas_production_in_sib' => 'Количество газа в СИБ, ст.м3/сут',
            'bsw' => 'Обводненность в ГУ, %',
            'daily_oil_production' => 'Суточная добыча нефти, т/сут',
            'heater_output_pressure' => 'Температура на выходе из печи в ГУ, С',
            'daily_water_production' => 'Суточная добыча воды, м3/сут',
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
