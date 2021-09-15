<?php

namespace App\Http\Requests\Economic;

use Illuminate\Foundation\Http\FormRequest;

class EconomicNrsWellsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'org_id' => 'required|integer|min:1',
            'field_id' => 'nullable|integer|min:1',
            'interval_start' => 'nullable|date',
            'interval_end' => 'nullable|date',
            'well_id' => 'nullable|string'
        ];
    }
}
