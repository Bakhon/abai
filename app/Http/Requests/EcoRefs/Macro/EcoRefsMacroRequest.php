<?php

namespace App\Http\Requests\EcoRefs\Macro;

use Illuminate\Foundation\Http\FormRequest;

class EcoRefsMacroRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required|integer|min:1',
        ];
    }
}
