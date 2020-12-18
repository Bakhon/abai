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
            'ngdu_id' => 'НГДУ',
            'cdng_id' => 'ЦДНГ',
            'gu_id' => 'ГУ',
            'zu_id' => 'ЗУ',
            'well_id' => 'Скважина',
            'date' => 'Дата и время',
            'field_id' => 'Месторождение',
            'fill' => 'Заправка',
            'level' => 'Уровень',
            'out_of_service_оf_dosing' => 'Простой дозатора, сутки',
            'current_dosage' => 'Фактическая дозировка, г/м3',
            'reason' => 'Причина',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'ngdu_id':
                case 'cdng_id':
                case 'gu_id':
                case 'zu_id':
                case 'well_id':
                case 'field_id':
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
