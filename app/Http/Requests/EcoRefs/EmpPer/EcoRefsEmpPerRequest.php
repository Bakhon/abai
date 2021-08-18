<?php

namespace App\Http\Requests\EcoRefs\EmpPer;

use Illuminate\Foundation\Http\FormRequest;

class EcoRefsEmpPerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required|integer|min:1',
        ];
    }
}
