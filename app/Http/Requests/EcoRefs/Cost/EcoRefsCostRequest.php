<?php

namespace App\Http\Requests\EcoRefs\Cost;

use Illuminate\Foundation\Http\FormRequest;

class EcoRefsCostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required|integer|min:1',
        ];
    }
}
