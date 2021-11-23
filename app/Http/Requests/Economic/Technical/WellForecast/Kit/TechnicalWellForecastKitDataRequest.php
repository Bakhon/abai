<?php

namespace App\Http\Requests\Economic\Technical\WellForecast\Kit;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalWellForecastKitDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'date' => 'nullable|date|date_format:Y-m-d',
            'technical_log_id' => 'nullable|integer|min:1',
            'economic_log_id' => 'nullable|integer|min:1',
        ];
    }
}
