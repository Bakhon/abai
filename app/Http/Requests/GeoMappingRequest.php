<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeoMappingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_ru' => 'required|string',
            'geo_id' => 'required|numeric',
        ];
    }
}
