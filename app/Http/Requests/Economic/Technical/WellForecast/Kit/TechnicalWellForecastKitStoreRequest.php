<?php

namespace App\Http\Requests\Economic\Technical\WellForecast\Kit;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalWellForecastKitStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'technical_log_id' => 'required|integer|min:1',
            'economic_log_id' => 'required|integer|min:1',
        ];
    }
}
