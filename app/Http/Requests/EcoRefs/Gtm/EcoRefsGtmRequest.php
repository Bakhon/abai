<?php

namespace App\Http\Requests\EcoRefs\Gtm;

use Illuminate\Foundation\Http\FormRequest;

class EcoRefsGtmRequest extends FormRequest
{
    public function rules()
    {
        return [
            'company_id' => 'nullable|integer|min:1',
        ];
    }
}
