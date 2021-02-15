<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class EditHistoryObserver
{

    static protected $classNames = [
        'field_id' => \App\Models\Refs\Field::class,
        'ngdu_id' => \App\Models\Refs\Ngdu::class,
        'cdng_id' => \App\Models\Refs\Cdng::class,
        'gu_id' => \App\Models\Refs\Gu::class,
        'zu_id' => \App\Models\Refs\Zu::class,
        'well_id' => \App\Models\Refs\Well::class,
        'water_type_by_sulin_id' => \App\Models\Refs\WaterTypeBySulin::class,
        'sulphate_reducing_bacteria_id' => \App\Models\Refs\SulphateReducingBacteria::class,
        'hydrocarbon_oxidizing_bacteria_id' => \App\Models\Refs\HydrocarbonOxidizingBacteria::class,
        'thionic_bacteria_id' => \App\Models\Refs\ThionicBacteria::class,
        'other_objects_id' => \App\Models\Refs\OtherObjects::class,
        'material_id' => \App\Models\ComplicationMonitoring\Material::class,
        'inhibitor_id' => \App\Models\Inhibitor::class,
    ];

    protected function save(Model $model, array $payload)
    {
        if(!auth()->check()) return;
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
