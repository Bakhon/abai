<?php

namespace App\Http\Requests\Technical\Structure;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalStuctureDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'cdng_id'=>'nullable|integer|min:1',
            'ngdu_id'=>'nullable|integer|min:1',
            'field_id'=>'nullable|integer|min:1',
            'company_id'=>'nullable|integer|min:1',
        ];
    }
}
