<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PipeTypesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'outside_diameter' => 'required|numeric',
            'inner_diameter' => 'required|numeric',
            'thickness' => 'required|numeric',
            'roughness' => 'required|numeric',
            'material_id' => 'required|numeric',
            'plot' => 'required|string',
        ];
    }
}
