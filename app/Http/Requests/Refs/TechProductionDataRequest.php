<?php

namespace App\Http\Requests\Refs;

use Illuminate\Foundation\Http\FormRequest;

class TechProductionDataRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source_id' => 'required',
            'gu_id' => 'required',
            'well_id' => 'required',
            'date' => 'nullable|date',
            'oil' => 'nullable|numeric',
            'liquid' => 'nullable|numeric',
            'days_worked' => 'nullable|numeric',
            'prs' => 'nullable|numeric',
        ];
    }
}
