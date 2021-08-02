<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BufferTankCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'field' => 'nullable|string',
            'ngdu_id' => 'nullable|numeric',
            'cdng_id' => 'nullable|numeric',
            'gu_id' => 'nullable|numeric',
            'model' => 'nullable|string',
            'name' => 'nullable|string',
            'type' => 'nullable|string',
            'volume' => 'nullable|numeric',
            'date_of_exploitation' => 'date',
            'current_state' => 'nullable|string',
            'extarnal_and_internal_inspection' => 'nullable|date',
            'hydraulic_test' => 'nullable|date',
            'date_of_repair' => 'nullable|date',
            'type_of_repair' => 'nullable|date',
        ];
    }
}
