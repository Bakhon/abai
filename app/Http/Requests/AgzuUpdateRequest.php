<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgzuUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gu_id' => 'nullable|numeric',
            'model' => 'nullable|string',
            'method_of_measurement' => 'nullable|string',
            'number_of_connected_wells' => 'nullable|numeric',
            'date_of_exploitation' => 'date',
            'current_state' => 'nullable|string',
            'date_of_repair' => 'nullable|date',
            'type_of_repair' => 'nullable|date',
            'passport_pdf' => 'nullable|string',
        ];
    }
}
