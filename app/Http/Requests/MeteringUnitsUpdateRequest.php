<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeteringUnitsUpdateRequest extends FormRequest
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
            'type' => 'nullable|string',
            'diameter' => 'nullable|numeric',
            'date_of_exploitation' => 'date',
            'current_state' => 'nullable|string',
            'date_of_repair' => 'nullable|date',
            'type_of_repair' => 'nullable|date',
        ];
    }
}
