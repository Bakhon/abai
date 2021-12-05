<?php

namespace App\Http\Requests\Economic\Scenario;

use Illuminate\Foundation\Http\FormRequest;

class EconomicScenarioDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa_id' => 'nullable|integer|min:1',
            'source_id' => 'nullable|integer|min:1',
            'gtm_kit_id' => 'nullable|integer|min:1',
        ];
    }
}
