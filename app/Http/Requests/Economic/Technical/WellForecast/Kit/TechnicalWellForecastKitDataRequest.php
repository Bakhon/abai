<?php

namespace App\Http\Requests\Economic\Technical\WellForecast\Kit;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalWellForecastKitDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'technical_log_id' => 'nullable|integer|min:1',
            'economic_log_id' => 'nullable|integer|min:1',
            'is_processed' => 'nullable|boolean'
        ];
    }
}
