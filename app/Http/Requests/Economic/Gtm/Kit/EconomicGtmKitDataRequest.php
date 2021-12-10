<?php

namespace App\Http\Requests\Economic\Gtm\Kit;

use Illuminate\Foundation\Http\FormRequest;

class EconomicGtmKitDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'gtm_log_id' => 'nullable|integer|min:1',
            'gtm_value_log_id' => 'nullable|integer|min:1',
        ];
    }
}
