<?php

namespace App\Http\Requests\Economic\Technical;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalDataForecastRequest extends FormRequest
{
    public function rules()
    {
        return [
            'source_id' => 'nullable|integer|min:1',
            'ngdu_id' => 'nullable|integer|min:1',
            'cdng_id' => 'nullable|integer|min:1',
            'gu_id' => 'nullable|integer|min:1',
            'only_well_id' => 'nullable|boolean',
        ];
    }
}
