<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cdng_id' => 'exists:cdngs,id',
            'name' => 'string',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
        ];
    }
}
