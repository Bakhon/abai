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
            'gtm_kit_id' => 'nullable|integer|min:1',
            'manufacturing_program_log_id' => 'nullable|integer|min:1',

            'params' => 'required|array',

            'params.cost_wr_payrolls' => 'required|array',
            'params.cost_wr_payrolls.*.value' => 'required|numeric|min:0|max:1',

            'params.fixed_nopayrolls' => 'required|array',
            'params.fixed_nopayrolls.*.value' => 'required|numeric|min:0|max:1',

            'params.oil_prices' => 'required|array',
            'params.oil_prices.*.value' => 'required|numeric|min:0',

            'params.dollar_rates' => 'required|array',
            'params.dollar_rates.*.value' => 'required|numeric|min:0',
        ];
    }
}
