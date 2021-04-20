<?php

namespace App\Http\Requests\Economic;

use Illuminate\Foundation\Http\FormRequest;

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
            'interval_start' => 'nullable|date',
            'interval_end' => 'nullable|date'
        ];
    }
}
