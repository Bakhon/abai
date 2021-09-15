<?php

namespace App\Http\Requests\Economic\Cost;

use Illuminate\Foundation\Http\FormRequest;

class EconomicCostDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required|integer|min:1',
        ];
    }
}
