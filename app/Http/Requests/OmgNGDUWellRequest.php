<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OmgNGDUWellRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bsw' => 'nullable|numeric',
            'daily_fluid_production' => 'nullable|numeric',
            'gas_factor' => 'nullable|numeric',
            'daily_oil_production' => 'nullable|numeric',
            'daily_water_production' => 'nullable|numeric',
            'date' => 'required|date',
            'temperature' => 'nullable|numeric',
            'pressure' => 'nullable|numeric',
            'well_id' => 'nullable|numeric',
            'zu_id' => 'nullable|numeric',
        ];
    }
}
