<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldValidationUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fields' => 'required|array',
            'fields.*.id' => 'required|numeric',
            'fields.*.min_value' => 'required|numeric',
            'fields.*.max_value' => 'required|numeric',
        ];
    }
}
