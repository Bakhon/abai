<?php

namespace App\Observers;

use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\WaterMeasurement;

class WaterMeasurementHistoryObserver extends EditHistoryObserver
{
    public function updated(WaterMeasurement $waterMeasurement)
    {
        $payload = $this->generatePayload($waterMeasurement);
        $this->save($waterMeasurement, $payload);
    }

    private function generatePayload(WaterMeasurement $waterMeasurement): array
    {
        $original = $waterMeasurement->getOriginal();
        $changes = $waterMeasurement->getChanges();

        $history = [];
        $fields = [
            'other_objects_id' => 'monitoring.field',
            'ngdu_id' => 'monitoring.ngdu',
            'cdng_id' => 'monitoring.cdng',
            'gu_id' => 'monitoring.gu',
            'zu_id' => 'monitoring.zu',
            'well_id' => 'monitoring.well',
            'date' => 'app.date_time',
            'hydrocarbonate_ion' => 'НСО3',
            'carbonate_ion' => 'СО32-',
            'sulphate_ion' => 'SO42-',
            'chlorum_ion' => 'Cl-',
            'calcium_ion' => 'Ca2+',
            'magnesium_ion' => 'Mg2+',
            'potassium_ion_sodium_ion' => 'Na+K+',
            'density' => 'monitoring.wm.fields.density',
            'ph' => 'рН',
            'mineralization' => 'monitoring.wm.fields.mineralization',
            'total_hardness' => 'monitoring.wm.fields.total_hardness',
            'water_type_by_sulin_id' => 'monitoring.wm.fields.water_type_by_sulin',
            'content_of_petrolium_products' => 'monitoring.wm.fields.content_of_petrolium_products',
            'mechanical_impurities' => 'monitoring.wm.fields.mechanical_impurities',
            'strontium_content' => 'monitoring.wm.fields.strontium_content',
            'barium_content' => 'monitoring.wm.fields.barium_content',
            'total_iron_content' => 'monitoring.wm.fields.total_iron_content',
            'ferric_iron_content' => 'monitoring.wm.fields.ferric_iron_content',
            'ferrous_iron_content' => 'monitoring.wm.fields.ferrous_iron_content',
            'hydrogen_sulfide' => 'monitoring.wm.fields.hydrogen_sulfide',
            'oxygen' => 'monitoring.wm.fields.oxygen',
            'carbon_dioxide' => 'monitoring.wm.fields.carbon_dioxide',
            'sulphate_reducing_bacteria_id' => 'monitoring.wm.fields.sulphate_reducing_bacteria',
            'hydrocarbon_oxidizing_bacteria_id' => 'monitoring.wm.fields.hydrocarbon_oxidizing_bacteria',
            'thionic_bacteria_id' => 'monitoring.wm.fields.thionic_bacteria',
        ];

        foreach ($fields as $field => $name) {
            switch ($field) {
                case 'ngdu_id':
                case 'cdng_id':
                case 'gu_id':
                case 'zu_id':
                case 'well_id':
                case 'water_type_by_sulin_id':
                case 'sulphate_reducing_bacteria_id':
                case 'hydrocarbon_oxidizing_bacteria_id':
                case 'thionic_bacteria_id':
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
