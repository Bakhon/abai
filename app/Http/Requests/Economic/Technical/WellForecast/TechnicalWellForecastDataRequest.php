<?php

namespace App\Http\Requests\Economic\Technical\WellForecast;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalWellForecastDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'uwi' => 'nullable|string',
        ];
    }
}
