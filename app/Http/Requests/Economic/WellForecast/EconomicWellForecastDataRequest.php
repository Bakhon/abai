<?php

namespace App\Http\Requests\Economic\WellForecast;

use Illuminate\Foundation\Http\FormRequest;

class EconomicWellForecastDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'uwi' => 'nullable|string',
        ];
    }
}
