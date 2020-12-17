<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OmgCACreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'q_v' => 'nullable|numeric',
            'gu_id' => 'nullable|numeric',
            'plan_dosage' => 'nullable|numeric',
            'all_gus' => 'nullable|boolean'
        ];
    }
}
