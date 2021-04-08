<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OmgUHEUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'field_id' => 'nullable|numeric',
            'gu_id' => 'nullable|numeric',
            'date' => 'date',
            'out_of_service_of_dosing' => 'nullable|boolean',
            'reason' => 'nullable|string',
            'ngdu_id' => 'nullable|numeric',
            'zu_id' => 'nullable|numeric',
            'inhibitor_id' => 'nullable|numeric',
            'daily_inhibitor_flowrate' => 'nullable|numeric',
            'fill' => 'nullable|numeric',
            'level' => 'nullable|numeric',
            'current_dosage' => 'nullable|numeric',
            'cdng_id' => 'nullable|numeric',
            'well_id' => 'nullable|numeric',
        ];
    }
}
