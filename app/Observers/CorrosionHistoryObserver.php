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
            'gu_id' => 'monitoring.gu.gu',
            'ngdu_id' => 'monitoring.ngdu',
            'cdng_id' => 'monitoring.cdng',
            'start_date_of_background_corrosion' => 'monitoring.corrosion.fields.start_date_of_background_corrosion',
            'final_date_of_background_corrosion' => 'monitoring.corrosion.fields.final_date_of_background_corrosion',
            'background_corrosion_velocity' => 'monitoring.corrosion.fields.background_corrosion_velocity',
            'start_date_of_corrosion_velocity_with_inhibitor_measure' => 'monitoring.corrosion.fields.start_date_of_corrosion_velocity_with_inhibitor_measure',
            'final_date_of_corrosion_velocity_with_inhibitor_measure' => 'monitoring.corrosion.fields.final_date_of_corrosion_velocity_with_inhibitor_measure',
            'corrosion_velocity_with_inhibitor' => 'monitoring.corrosion.fields.corrosion_velocity_with_inhibitor',
            'sample_number' => 'monitoring.corrosion.fields.sample_number',
            'weight_before' => 'monitoring.corrosion.fields.weight_before',
            'days' => 'monitoring.corrosion.fields.days',
            'weight_after' => 'monitoring.corrosion.fields.weight_after',
            'avg_speed' => 'monitoring.corrosion.fields.avg_speed',
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
