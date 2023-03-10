<?php

namespace App\Http\Requests\Economic;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Level23\Druid\Types\Granularity;

class EconomicNrsWellsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'org_id' => 'required|integer|min:1',
            'field_id' => 'nullable|integer|min:1',
            'interval_start' => 'required|date',
            'interval_end' => 'required|date',
            'well_id' => 'nullable|string',
            'granularity' => [
                'required',
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
