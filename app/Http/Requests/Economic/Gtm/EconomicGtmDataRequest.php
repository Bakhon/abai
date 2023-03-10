<?php

namespace App\Http\Requests\Economic\Gtm;

use Illuminate\Foundation\Http\FormRequest;

class EconomicGtmDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'company_id' => 'nullable|integer|min:1',
            'author_id' => 'nullable|integer|min:1',
            'log_id' => 'nullable|integer|min:1',
        ];
    }
}
