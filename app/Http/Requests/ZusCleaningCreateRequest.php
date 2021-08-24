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
            'gu_id' => 'nullable|numeric',
            'zu_id' => 'nullable|numeric',
            'date' => 'nullable|date',
            'number_of_failures' => 'nullable|numeric',
            'failure_reason' => 'nullable||string',
            'repair_period' => 'nullable|string',

        ];
    }
}
