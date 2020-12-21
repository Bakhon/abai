<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WaterMeasurementUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'other_objects_id' => 'nullable|numeric',
            'ngdu_id' => 'nullable|numeric',
            'cdng_id' => 'nullable|numeric',
            'gu_id' => 'nullable|numeric',
            'zu_id' => 'nullable|numeric',
            'well_id' => 'nullable|numeric',
            'date' => 'date',
            'hydrocarbonate_ion' => 'nullable|numeric',
            'carbonate_ion' => 'nullable|numeric',
            'sulphate_ion' => 'nullable|numeric',
            'chlorum_ion' => 'nullable|numeric',
            'calcium_ion' => 'nullable|numeric',
            'magnesium_ion' => 'nullable|numeric',
            'potassium_ion_sodium_ion' => 'nullable|numeric',
            'density' => 'nullable|numeric',
            'ph' => 'nullable|numeric',
            'mineralization' => 'nullable|numeric',
            'total_hardness' => 'nullable|numeric',
            'water_type_by_sulin_id' => 'nullable|numeric',
            'content_of_petrolium_products' => 'nullable|numeric',
            'mechanical_impurities' => 'nullable|numeric',
            'strontium_content' => 'nullable|numeric',
            'barium_content' => 'nullable|numeric',
            'total_iron_content' => 'nullable|numeric',
            'ferric_iron_content' => 'nullable|numeric',
            'ferrous_iron_content' => 'nullable|numeric',
            'hydrogen_sulfide' => 'nullable|numeric',
            'oxygen' => 'nullable|numeric',
            'carbon_dioxide' => 'nullable|numeric',
            'sulphate_reducing_bacteria_id' => 'nullable|numeric',
            'hydrocarbon_oxidizing_bacteria_id' => 'nullable|numeric',
            'thionic_bacteria_id' => 'nullable|numeric',
        ];
    }
}
