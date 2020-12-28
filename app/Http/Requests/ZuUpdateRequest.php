<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZuUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gu_id' => 'exists:gus,id',
            'name' => 'string',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
        ];
    }
}
