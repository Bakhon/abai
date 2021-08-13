<?php

namespace App\Http\Requests\EcoRefs\Gtm;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcoRefsGtmRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'company_id' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'pi' => 'required|numeric',
            'comment' => 'nullable|string',
        ];
    }
}
