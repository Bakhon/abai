<?php

namespace App\Http\Requests\Economic\Scenario;

use Illuminate\Foundation\Http\FormRequest;

class EconomicScenarioStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'sc_fa_id' => 'required|integer|min:1',
            'source_id' => 'required|integer|min:1',
            'gtm_log_id' => 'required|integer|min:1',

            'params' => 'required|array',

            'params.fixed_payroll' => 'required|array',
            'params.fixed_payroll.*.value' => 'required|numeric|min:0|max:1',

            'params.fixed_nopayrolls' => 'required|array',
            'params.fixed_nopayrolls.*.value' => 'required|numeric|min:0|max:1',

            'params.oil_prices' => 'required|array',
            'params.oil_prices.*.value' => 'required|numeric|min:0',

            'params.dollar_rates' => 'required|array',
            'params.dollar_rates.*.value' => 'required|numeric|min:0',
        ];
    }
}
