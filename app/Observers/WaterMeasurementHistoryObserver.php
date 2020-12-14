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
            'other_objects_id' => 'Месторождение',
            'ngdu_id' => 'НГДУ',
            'cdng_id' => 'ЦДНГ',
            'gu_id' => 'ГУ',
            'zu_id' => 'ЗУ',
            'well_id' => 'Скважина',
            'date' => 'Дата и время',
            'hydrocarbonate_ion' => 'НСО3',
            'carbonate_ion' => 'СО32-',
            'sulphate_ion' => 'SO42-',
            'chlorum_ion' => 'Cl-',
            'calcium_ion' => 'Ca2+',
            'magnesium_ion' => 'Mg2+',
            'potassium_ion_sodium_ion' => 'Na+K+',
            'density' => 'Плотность при 20°С, г/см3',
            'ph' => 'рН',
            'mineralization' => 'Общая минерализация, мг/дм3',
            'total_hardness' => 'Общая жесткость, мг-экв/дм3',
            'water_type_by_sulin_id' => 'Тип воды по Сулину',
            'content_of_petrolium_products' => 'Содержание нефтепродуктов, мг/дм3',
            'mechanical_impurities' => 'Механические примеси, мг/дм3',
            'strontium_content' => 'Cодержание стронция, мг/дм³',
            'barium_content' => 'Содержание бария, мг/дм³',
            'total_iron_content' => 'Содержание общего железа мг/дм3',
            'ferric_iron_content' => 'Содержание трехвалентного железа мг/дм3',
            'ferrous_iron_content' => 'Содержание двухвалентного железа мг/дм3',
            'hydrogen_sulfide' => 'H2S, мг/дм3 (после буферной емкости)',
            'oxygen' => 'О2, мг/дм3',
            'carbon_dioxide' => 'CO2, мг/дм3 (после буферной емкости)',
            'sulphate_reducing_bacteria_id' => 'СВБ, кл/см3',
            'hydrocarbon_oxidizing_bacteria_id' => 'СВБ, кл/см3',
            'thionic_bacteria_id' => 'ТБ, кл/см3',
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
