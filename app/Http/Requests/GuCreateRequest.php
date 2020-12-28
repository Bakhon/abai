<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cdng_id' => 'required|exists:cdngs,id',
            'name' => 'required|string',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
        ];
    }
}
