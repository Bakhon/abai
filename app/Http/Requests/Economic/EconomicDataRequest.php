<?php

namespace App\Http\Requests\Economic;

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
            'org' => 'required|integer|min:1',
            'dpz' => 'nullable|string',
            'granularity' => [
                'required',
                'string',
                Rule::in([
                    Granularity::MONTH,
                    Granularity::DAY,
                ])
            ],
            'interval_start' => 'nullable|date',
            'interval_end' => 'nullable|date',
        ];
    }
}
