<?php

namespace App\Http\Requests\EcoRefs\ScFa;

use Illuminate\Foundation\Http\FormRequest;

class StoreEcoRefsScFaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string'
        ];
    }
}
