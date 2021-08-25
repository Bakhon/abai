<?php

namespace App\Http\Requests\EcoRefs\DiscontCoefBar;

use Illuminate\Foundation\Http\FormRequest;

class EcoRefsDiscontCoefBarRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required|integer|min:1',
        ];
    }
}
