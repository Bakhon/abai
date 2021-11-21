<?php

namespace App\Http\Requests\Economic\Analysis;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Level23\Druid\Types\Granularity;

class EconomicAnalysisWellByGranularityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'uwi' => 'nullable|string',
            'granularity' => [
                'nullable',
                'string',
                Rule::in([
                    Granularity::DAY,
                    Granularity::MONTH,
                    Granularity::YEAR,
                ])
            ],
            'permanent_stop_coefficient' => 'required|numeric',
            'kit_id' => 'required|integer|min:1',
        ];
    }
}
