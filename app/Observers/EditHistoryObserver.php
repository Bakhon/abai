<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class EditHistoryObserver
{
    protected function save(Model $model, array $payload)
    {
        $historyItem = new \App\EditHistory([
            'user' => auth()->user()->name,
            'entity_id' => $model->id,
            'entity_type' => get_class($model),
            'date_prev_change' => $model->getOriginal('updated_at'),
            'payload' => $payload
        ]);
        $historyItem->save();
    }
}
