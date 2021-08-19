<?php

namespace App\Http\Requests\EcoRefs\Macro;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcoRefsMacroRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required',
            'date' => 'required',
            'ex_rate_dol' => 'nullable|numeric',
            'ex_rate_rub' => 'nullable|numeric',
            'inf_end' => 'nullable|numeric',
            'barrel_world_price' => 'nullable|numeric',
        ];
    }
}
