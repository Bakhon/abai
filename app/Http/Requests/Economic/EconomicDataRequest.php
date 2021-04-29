<?php

namespace App\Http\Requests\Economic;

use App\Http\Controllers\EconomicController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Level23\Druid\Types\Granularity;

class EconomicDataRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
                    EconomicController::PROFITABILITY_FULL,
                    EconomicController::PROFITABILITY_DIRECT,
                    EconomicController::PROFITABILITY_DIRECT_FROM_DATE,
                ])
            ],

        ];
    }
}
