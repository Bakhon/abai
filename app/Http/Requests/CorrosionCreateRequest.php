<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorrosionCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'background_corrosion_velocity' => 'nullable|numeric',
            'cdng_id' => 'nullable|numeric',
            'corrosion_velocity_with_inhibitor' => 'nullable|numeric',
            'final_date_of_background_corrosion' => 'nullable|date',
            'final_date_of_corrosion_velocity_with_inhibitor_measure' => 'nullable|date',
            'gu_id' => 'nullable|numeric',
            'ngdu_id' => 'nullable|numeric',
            'start_date_of_background_corrosion' => 'date',
            'start_date_of_corrosion_velocity_with_inhibitor_measure' => 'nullable|date',
            'sample_number' => 'nullable|numeric',
            'weight_before' => 'nullable|numeric',
            'days' => 'nullable|numeric',
            'weight_after' => 'nullable|numeric',
            'avg_speed' => 'nullable|numeric',
        ];
    }
}
