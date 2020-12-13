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
            'year' => 'Год',
            'gu_id' => 'ГУ',
            'plan_dosage' => 'Планируемая дозировка, г/м3',
            'q_v' => 'Qв, тыс.м³/год'
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
                    $newValue = isset($changes[$field]) ? $changes[$field] : $oldValue;
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
