<?php

namespace App\Http\Requests\EcoRefs\TarifyTn;

use Illuminate\Foundation\Http\FormRequest;

class EcoRefsTarifyTnRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required|integer|min:1',
        ];
    }
}
