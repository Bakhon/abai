<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZuCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gu_id' => 'required|exists:gus,id',
            'name' => 'required|string',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
        ];
    }
}
