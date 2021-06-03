<?php

namespace App\Observers;

use App\Models\ComplicationMonitoring\Gu;

class GuHistoryObserver extends EditHistoryObserver
{
    public function updated(Gu $gu)
    {
        $payload = $this->generatePayload($gu);
        $this->save($gu, $payload);
    }

    private function generatePayload(Gu $gu): array
    {
        $original = $gu->getOriginal();
        $changes = $gu->getChanges();

        $history = [];
        $fields = [
            'cdng_id' => 'monitoring.cdng',
            'name' => 'app.param_name',
            'lat' => 'app.lat',
            'lon' => 'app.lon',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
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
