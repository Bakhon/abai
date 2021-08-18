<?php

namespace App\Http\Requests\EcoRefs\GtmValue;

use Illuminate\Foundation\Http\FormRequest;

class EcoRefsGtmValueRequest extends FormRequest
{
    public function rules()
    {
        return [
            'company_id' => 'nullable|integer|min:1',
            'gtm_id' => 'nullable|integer|min:1',
        ];
    }
}
