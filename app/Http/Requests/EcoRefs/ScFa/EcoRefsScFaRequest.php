<?php

namespace App\Http\Requests\EcoRefs\ScFa;

use Illuminate\Foundation\Http\FormRequest;

class EcoRefsScFaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'is_forecast' => 'nullable|boolean'
        ];
    }
}
