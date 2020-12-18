<?php

namespace App\Observers;

use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\WaterMeasurement;

class CorrosionHistoryObserver extends EditHistoryObserver
{
    public function updated(Corrosion $corrosion)
    {
        $payload = $this->generatePayload($corrosion);
        $this->save($corrosion, $payload);
    }

    private function generatePayload(Corrosion $corrosion): array
    {
        $original = $corrosion->getOriginal();
        $changes = $corrosion->getChanges();

        $history = [];
        $fields = [
            'gu_id' => 'ГУ',
            'ngdu_id' => 'НГДУ',
            'cdng_id' => 'ЦДНГ',
            'start_date_of_background_corrosion' => 'Дата начала',
            'final_date_of_background_corrosion' => 'Дата окончания',
            'background_corrosion_velocity' => 'Фоновая скорость',
            'start_date_of_corrosion_velocity_with_inhibitor_measure' => 'Дата начало замера скорости коррозии с реагентом',
            'final_date_of_corrosion_velocity_with_inhibitor_measure' => 'Дата окончания замера скорости коррозии с реагентом',
            'corrosion_velocity_with_inhibitor' => 'Скорость коррозии',
            'sample_number' => 'Номер образца-свидетеля',
            'weight_before' => 'Масса до установки, гр',
            'days' => 'Количество дней экспозиции',
            'weight_after' => 'Масса после извлечения, гр',
            'avg_speed' => 'Средняя скорость коррозии, мм/г',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'gu_id':
                case 'ngdu_id':
                case 'cdng_id':
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
