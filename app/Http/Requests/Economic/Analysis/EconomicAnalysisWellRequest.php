<?php

namespace App\Http\Requests\Economic\Analysis;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Level23\Druid\Types\Granularity;

class EconomicAnalysisWellRequest extends FormRequest
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
            'date' => 'required|date',
        ];
    }
}
