<?php

namespace App\Http\Requests\Technical;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalDataForecastRequest extends FormRequest
{
    public function rules()
    {
        return [
            'source_id' => 'required|integer|min:1',
        ];
    }
}