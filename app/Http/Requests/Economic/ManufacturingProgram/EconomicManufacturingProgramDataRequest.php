<?php

namespace App\Http\Requests\Economic\ManufacturingProgram;

use Illuminate\Foundation\Http\FormRequest;

class EconomicManufacturingProgramDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'company_id' => 'nullable|integer|min:1',
            'user_id' => 'nullable|integer|min:1',
            'log_id' => 'nullable|integer|min:1',
        ];
    }
}
