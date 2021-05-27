<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_ru' => 'required|string'
        ];
    }
}
