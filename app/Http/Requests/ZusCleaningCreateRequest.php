<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZusCleaningCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'zu_id' => 'nullable|numeric',
            'date' => 'nullable|date',
            'number_of_failures' => 'nullable|numeric',
        ];
    }
}
