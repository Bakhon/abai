<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OmgCAUpdateRequest extends FormRequest
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
            'date' => 'date',
            'q_v' => 'nullable|numeric',
            'gu_id' => 'numeric',
            'plan_dosage' => 'nullable|numeric',
        ];
    }
}
