<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PipeCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gu_id' => 'required|numeric',
            'length' => 'required|numeric',
            'outside_diameter' => 'required|numeric',
            'inner_diameter' => 'nullable|numeric',
            'thickness' => 'nullable|numeric',
            'roughness' => 'required|numeric',
            'material_id' => 'nullable|numeric',
            'plot' => 'nullable|numeric',
        ];
    }
}
