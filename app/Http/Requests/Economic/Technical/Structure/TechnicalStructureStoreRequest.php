<?php

namespace App\Http\Requests\Economic\Technical\Structure;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalStructureStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }
}
