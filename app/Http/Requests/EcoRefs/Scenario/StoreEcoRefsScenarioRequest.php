<?php

namespace App\Http\Requests\EcoRefs\Scenario;

use Illuminate\Foundation\Http\FormRequest;

class StoreEcoRefsScenarioRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'sc_fa_id' => 'required|integer|min:1',

            'params' => 'required|array',
            'params.optimizations' => 'required|array',
            'params.optimizations.*.fixed_nopayroll' => 'required|numeric|min:0|max:1',
            'params.optimizations.*.fixed_payroll' => 'required|numeric|min:0|max:1',

            'params.oil_prices' => 'required|array',
            'params.oil_prices.*.value' => 'required|numeric|min:0',

            'params.course_prices' => 'required|array',
            'params.course_prices.*.value' => 'required|numeric|min:0',
        ];
    }
}
