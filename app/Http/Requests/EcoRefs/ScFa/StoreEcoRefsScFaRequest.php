<?php

namespace App\Http\Requests\EcoRefs\ScFa;

use Illuminate\Foundation\Http\FormRequest;

class StoreEcoRefsScFaRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this['is_forecast'] = (bool)request()->input('is_forecast');
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'is_forecast' => 'required|boolean'
        ];
    }
}
