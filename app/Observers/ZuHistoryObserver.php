<?php

namespace App\Observers;

use App\Models\Refs\Zu;

class ZuHistoryObserver extends EditHistoryObserver
{
    public function updated(Zu $zu)
    {
        $payload = $this->generatePayload($zu);
        $this->save($zu, $payload);
    }

    private function generatePayload(Zu $zu): array
    {
        $original = $zu->getOriginal();
        $changes = $zu->getChanges();

        $history = [];
        $fields = [
            'gu_id' => 'monitoring.gu',
            'name' => 'app.param_name',
            'lat' => 'app.lat',
            'lon' => 'app.lon',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'gu_id':
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
