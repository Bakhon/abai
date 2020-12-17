<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PipeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gu_id' => 'numeric',
            'length' => 'numeric',
            'outside_diameter' => 'numeric',
            'inner_diameter' => 'nullable|numeric',
            'thickness' => 'nullable|numeric',
            'roughness' => 'numeric',
            'material_id' => 'nullable|numeric',
            'plot' => 'nullable|numeric',
        ];
    }
}
