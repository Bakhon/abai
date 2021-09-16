<?php

namespace App\Http\Requests\Economic\Log;

use App\Models\Refs\EconomicDataLogType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EconomicDataLogRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type_id' => [
                'nullable',
                'integer',
                Rule::in(EconomicDataLogType::ids())
            ],
            'author_id' => 'nullable|integer|min:1'
        ];
    }
}
