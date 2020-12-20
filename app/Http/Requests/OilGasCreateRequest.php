<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OilGasCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'carbon_dioxide_in_gas'   => 'nullable|numeric',
            'cdng_id'                 => 'nullable|numeric',
            'date'                    => 'required|date',
            'gas_density_at_20'       => 'nullable|numeric',
            'gas_viscosity_at_20'     => 'nullable|numeric',
            'gu_id'                   => 'nullable|numeric',
            'hydrogen_sulfide_in_gas' => 'nullable|numeric',
            'ngdu_id'                 => 'nullable|numeric',
            'oil_viscosity_at_20'     => 'nullable|numeric',
            'oil_viscosity_at_40'     => 'nullable|numeric',
            'oil_viscosity_at_50'     => 'nullable|numeric',
            'oil_viscosity_at_60'     => 'nullable|numeric',
            'other_objects_id'        => 'nullable|numeric',
            'oxygen_in_gas'           => 'nullable|numeric',
            'water_density_at_20'     => 'nullable|numeric',
            'well_id'                 => 'nullable|numeric',
            'zu_id'                   => 'nullable|numeric',
        ];
    }
}
