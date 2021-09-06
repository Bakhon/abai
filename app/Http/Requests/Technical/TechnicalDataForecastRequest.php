<?php

namespace App\Http\Requests\Technical;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalDataForecastRequest extends FormRequest
{
    public function rules()
    {
        return [
            'source_id' => 'nullable|integer|min:1',
            'gu_id' => 'nullable|integer|min:1',
        ];
    }
}
