<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InhibitorUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'price' => 'numeric',
            'date_from' => 'date',
        ];
    }
}
