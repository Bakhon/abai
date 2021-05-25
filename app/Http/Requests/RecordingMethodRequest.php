<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordingMethodRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string'
        ];
    }
}
