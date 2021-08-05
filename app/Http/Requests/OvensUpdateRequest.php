<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OvensUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gu_id' => 'nullable|numeric',
            'cipher' => 'nullable|string',
            'type' => 'nullable|string',
            'rated_heat_output' => 'nullable|numeric',
            'date_of_exploitation' => 'date',
            'current_state' => 'nullable|string',
            'date_of_repair' => 'nullable|date',
            'type_of_repair' => 'nullable|date',
        ];
    }
}
