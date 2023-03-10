<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OmgNGDUCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bsw' => 'nullable|numeric',
            'cdng_id' => 'nullable|numeric',
            'daily_fluid_production' => 'nullable|numeric',
            'daily_gas_production_in_sib' => 'nullable|numeric',
            'daily_oil_production' => 'nullable|numeric',
            'daily_water_production' => 'nullable|numeric',
            'date' => 'required|date',
            'field_id' => 'nullable|numeric',
            'gu_id' => 'nullable|numeric',
            'heater_inlet_temperature' => 'nullable|numeric',
            'heater_output_temperature' => 'nullable|numeric',
            'ngdu_id' => 'nullable|numeric',
            'pump_discharge_pressure' => 'nullable|numeric',
            'surge_tank_pressure' => 'nullable|numeric',
            'well_id' => 'nullable|numeric',
            'zu_id' => 'nullable|numeric',
            'sg_oil' => 'nullable|numeric',
            'sg_gas' => 'nullable|numeric',
            'sg_water' => 'nullable|numeric',
        ];
    }
}
