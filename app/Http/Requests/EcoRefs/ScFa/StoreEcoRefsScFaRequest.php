<?php

namespace App\Http\Requests\EcoRefs\ScFa;

use Illuminate\Foundation\Http\FormRequest;

class StoreEcoRefsScFaRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this['is_fact'] = (bool)request()->input('is_fact');
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'is_fact' => 'required|boolean'
        ];
    }
}
