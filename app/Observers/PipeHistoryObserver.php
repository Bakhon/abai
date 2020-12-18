<?php

namespace App\Observers;

use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\Pipe;
use App\Models\ComplicationMonitoring\WaterMeasurement;

class PipeHistoryObserver extends EditHistoryObserver
{
    public function updated(Pipe $pipe)
    {
        $payload = $this->generatePayload($pipe);
        $this->save($pipe, $payload);
    }

    private function generatePayload(Pipe $pipe): array
    {
        $original = $pipe->getOriginal();
        $changes = $pipe->getChanges();

        $history = [];
        $fields = [
            'gu_id' => 'ГУ',
            'length' => 'Длина',
            'outside_diameter' => 'Внешний диаметр',
            'inner_diameter' => 'Внутренний диаметр',
            'thickness' => 'Толщина стенок',
            'roughness' => 'Жесткость',
            'material_id' => 'Материал',
            'plot' => 'Участок',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'gu_id':
                case 'material_id':
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
