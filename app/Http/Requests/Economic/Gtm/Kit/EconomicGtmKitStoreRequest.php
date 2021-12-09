<?php

namespace App\Http\Requests\Economic\Gtm\Kit;

use Illuminate\Foundation\Http\FormRequest;

class EconomicGtmKitStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'gtm_log_id' => 'required|integer|min:1',
            'gtm_value_log_id' => 'required|integer|min:1',
        ];
    }
}
