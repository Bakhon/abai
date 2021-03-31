<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OmgUHECreateRequest extends FormRequest
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
            'date' => 'required|date',
            'out_of_service_of_dosing' => 'nullable|numeric',
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
            'consumption' => 'nullable|numeric',
        ];
    }
}
