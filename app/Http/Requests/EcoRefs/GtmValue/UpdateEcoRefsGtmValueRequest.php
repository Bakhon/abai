<?php

namespace App\Http\Requests\EcoRefs\GtmValue;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcoRefsGtmValueRequest extends FormRequest
{
    public function rules()
    {
        return [
            'date' => 'required|date',
            'company_id' => 'required|integer|min:1',
            'gtm_id' => 'required|integer|min:1',
            'priority' => 'required|integer|min:1',
            'growth' => 'required|numeric',
            'amount' => 'required|integer|min:1',
            'comment' => 'nullable|string',
        ];
    }
}
