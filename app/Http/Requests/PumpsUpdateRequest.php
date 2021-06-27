<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PumpsUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'field' => 'nullable|string',
            // 'ngdu_id' => 'nullable|numeric',
            // 'cdng_id' => 'nullable|numeric',
            'gu_id' => 'nullable|numeric',
            'number' => 'nullable|string',
            'model' => 'nullable|string',
            'type' => 'nullable|string',
            'perfomance' => 'nullable|numeric',
            'power' => 'nullable|numeric',
            'date_of_exploitation' => 'date',
            'current_state' => 'nullable|string',
            'date_of_repair' => 'nullable|date',
            'type_of_repair' => 'nullable|date',
        ];
    }
}
