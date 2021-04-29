<?php

namespace App\Http\Requests\EcoRefs\Scenario;

use Illuminate\Foundation\Http\FormRequest;

class StoreEcoRefsScenarioRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'sc_fa_id' => 'required|integer|min:1'
        ];
    }
}
