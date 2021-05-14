<?php

namespace App\Observers;

use App\Models\ComplicationMonitoring\OmgCA;

class OmgCAHistoryObserver extends EditHistoryObserver
{
    public function updated(OmgCA $omgCA)
    {
        $payload = $this->generatePayload($omgCA);
        $this->save($omgCA, $payload);
    }

    private function generatePayload(OmgCA $omgCA): array
    {
        $original = $omgCA->getOriginal();
        $changes = $omgCA->getChanges();

        $history = [];
        $fields = [
            'year' => 'app.year',
            'gu_id' => 'monitoring.gu.gu',
            'plan_dosage' => 'monitoring.omgca.fields.plan_dosage',
            'q_v' => 'monitoring.omgca.fields.q_v'
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'year':
                    $oldValue = \Carbon\Carbon::parse($original['date'])->format('Y');
                    $newValue = isset($changes['date']) ? \Carbon\Carbon::parse($changes['date'])->format('Y') : $oldValue;
                    break;
                case 'gu_id':
                    $oldValue = $original['gu_id'] ? \App\Models\Refs\Gu::find($original['gu_id'])->name : null;
                    $newValue = isset($changes['gu_id']) ? \App\Models\Refs\Gu::find($changes['gu_id'])->name : $oldValue;
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
