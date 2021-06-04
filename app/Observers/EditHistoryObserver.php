<?php

namespace App\Observers;

use App\EditHistory;
use App\Models\ComplicationMonitoring\Cdng;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\Material;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use App\Models\Inhibitor;
use App\Models\Refs\Field;
use App\Models\Refs\HydrocarbonOxidizingBacteria;
use App\Models\Refs\OtherObjects;
use App\Models\Refs\SulphateReducingBacteria;
use App\Models\Refs\ThionicBacteria;
use App\Models\Refs\WaterTypeBySulin;
use Illuminate\Database\Eloquent\Model;

class EditHistoryObserver
{

    static protected $classNames = [
        'field_id' => Field::class,
        'ngdu_id' => Ngdu::class,
        'cdng_id' => Cdng::class,
        'gu_id' => Gu::class,
        'zu_id' => Zu::class,
        'well_id' => Well::class,
        'water_type_by_sulin_id' => WaterTypeBySulin::class,
        'sulphate_reducing_bacteria_id' => SulphateReducingBacteria::class,
        'hydrocarbon_oxidizing_bacteria_id' => HydrocarbonOxidizingBacteria::class,
        'thionic_bacteria_id' => ThionicBacteria::class,
        'other_objects_id' => OtherObjects::class,
        'material_id' => Material::class,
        'inhibitor_id' => Inhibitor::class,
    ];

    protected function save(Model $model, array $payload)
    {
        if(!auth()->check()) return;
        $historyItem = new EditHistory([
            'user' => auth()->user()->name,
            'entity_id' => $model->id,
            'entity_type' => get_class($model),
            'date_prev_change' => $model->getOriginal('updated_at'),
            'payload' => $payload
        ]);
        $historyItem->save();
    }
}
