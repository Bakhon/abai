<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorrosionIterativeCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gu_id' => 'nullable|numeric',
            'background_corrosion_velocity' => 'nullable|numeric',
            'date_for_corrosion' => 'nullable|date',
            'carbon_dioxide' => 'nullable|numeric',
            'date_for_carbon_dioxide' => 'nullable|date',
            'volume_fractions_for_carbon_dioxide' => 'nullable|numeric',
            'surge_tank_pressure' => 'nullable|numeric',
            'carbon_dioxide_pressure' => 'nullable|numeric',
            'hydrogen_sulfide_in_gas' => 'nullable|numeric',
            'date_for_hydrogen_sulfide' => 'nullable|date',
            'volume_fractions_for_hydrogen_sulfide' => 'nullable|numeric',
            'hydrogen_sulfide_in_gas' => 'nullable|numeric',
            'calculated_corrosion_speed' => 'nullable|numeric'
            // 'cdng_id' => 'nullable|numeric',
            // 'corrosion_velocity_with_inhibitor' => 'nullable|numeric',
            // 'final_date_of_background_corrosion' => 'nullable|date',
            // 'final_date_of_corrosion_velocity_with_inhibitor_measure' => 'nullable|date',
            // 'ngdu_id' => 'nullable|numeric',
            // 'start_date_of_corrosion_velocity_with_inhibitor_measure' => 'nullable|date',
            // 'sample_number' => 'nullable|numeric',
            // 'weight_before' => 'nullable|numeric',
            // 'days' => 'nullable|numeric',
            // 'weight_after' => 'nullable|numeric',
            // 'avg_speed' => 'nullable|numeric',
        ];
    }
}
