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
            'granularity' => [
                'nullable',
                'string',
                Rule::in([
                    Granularity::DAY,
                    Granularity::MONTH,
                    Granularity::YEAR,
                ])
            ],
        ];
    }
}
