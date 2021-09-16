<?php

namespace App\Http\Requests\Economic\Gtm\Value;

use Illuminate\Foundation\Http\FormRequest;

class EconomicGtmValueDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'company_id' => 'nullable|integer|min:1',
            'author_id' => 'nullable|integer|min:1',
            'gtm_id' => 'nullable|integer|min:1',
            'log_id' => 'nullable|integer|min:1',
        ];
    }
}
