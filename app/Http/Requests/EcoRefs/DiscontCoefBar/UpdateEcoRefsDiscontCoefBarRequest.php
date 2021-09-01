<?php

namespace App\Http\Requests\EcoRefs\DiscontCoefBar;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcoRefsDiscontCoefBarRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required',
            'date' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'barr_coef' => 'nullable|numeric',
            'discont' => 'nullable|numeric',
            'macro' => 'nullable|numeric',
        ];
    }
}
