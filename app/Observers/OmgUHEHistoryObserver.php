<?php

namespace App\Observers;

use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\WaterMeasurement;

class OmgUHEHistoryObserver extends EditHistoryObserver
{
    public function updated(OmgUHE $omgUHE)
    {
        $payload = $this->generatePayload($omgUHE);
        $this->save($omgUHE, $payload);
    }

    private function generatePayload(OmgUHE $omgUHE): array
    {
        $original = $omgUHE->getOriginal();
        $changes = $omgUHE->getChanges();

        $history = [];
        $fields = [
            'ngdu_id' => 'monitoring.ngdu',
            'cdng_id' => 'monitoring.cdng',
            'gu_id' => 'monitoring.gu',
            'zu_id' => 'monitoring.zu',
            'well_id' => 'monitoring.well',
            'date' => 'app.date_time',
            'inhibitor_id' => 'monitoring.omguhe.fields.inhibitor',
            'field_id' => 'monitoring.field',
            'fill' => 'monitoring.omguhe.fields.fill',
            'level' => 'monitoring.level',
            'out_of_service_оf_dosing' => 'monitoring.omguhe.fields.dosator_idle',
            'current_dosage' => 'monitoring.omguhe.fields.fact_dosage',
            'reason' => 'monitoring.omguhe.fields.reason',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'ngdu_id':
                case 'cdng_id':
                case 'gu_id':
                case 'zu_id':
                case 'well_id':
                case 'field_id':
                case 'inhibitor_id':
                    $classname = self::$classNames[$field];
                    $oldValue = $original[$field] ? $classname::find($original[$field])->name : null;
                    $newValue = isset($changes[$field]) ? $classname::find(
                        $changes[$field]
                    )->name : $oldValue;
                    break;
                case 'out_of_service_оf_dosing':
                    $oldValue = $original[$field] ? 'да' : 'нет';
                    $newValue = array_key_exists($field, $changes) ? ($original[$field] != $changes[$field] ? ($changes[$field] ? 'да' : 'нет') : null) : $oldValue;
                    break;
                case 'current_dosage':
                    $oldValue = round($original[$field], 1);
                    $newValue = array_key_exists($field, $changes) ? round($changes[$field], 1) : $oldValue;
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
