<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexFieldRequest extends FormRequest
{
    public function rules()
    {
        return [
            'org_id' => 'nullable|integer|min:1'
        ];
    }
}
