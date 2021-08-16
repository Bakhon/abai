<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'yield_point' => 'required|numeric',
            'roughness' => 'required|numeric',
            'material_id' => 'required|numeric',
        ];
    }
}
