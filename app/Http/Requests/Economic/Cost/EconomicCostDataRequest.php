<?php

namespace App\Http\Requests\Economic\Cost;

use Illuminate\Foundation\Http\FormRequest;

class EconomicCostDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'nullable|integer|min:1',
            'company_id' => 'nullable|integer|min:1',
        ];
    }
}
