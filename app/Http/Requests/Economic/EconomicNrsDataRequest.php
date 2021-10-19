<?php

namespace App\Http\Requests\Economic;

use App\Http\Controllers\Economic\EconomicNrsController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Level23\Druid\Types\Granularity;

class EconomicNrsDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'org_id' => 'required|integer|min:1',
            'field_id' => 'nullable|integer|min:1',
            'interval_start' => 'nullable|date',
            'interval_end' => 'nullable|date',
            'granularity' => [
                'required',
                'string',
                Rule::in([
                    Granularity::MONTH,
                    Granularity::DAY,
                ])
            ],
            'profitability' => [
                'required',
                'string',
                Rule::in([
                    EconomicNrsController::PROFITABILITY_FULL,
                    EconomicNrsController::PROFITABILITY_DIRECT,
                    EconomicNrsController::PROFITABILITY_DIRECT_FROM_DATE,
                ])
            ],
            'exclude_uwis' => 'nullable|array'
        ];
    }
}
