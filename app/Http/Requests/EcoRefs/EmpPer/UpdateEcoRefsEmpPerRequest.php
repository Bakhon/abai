<?php

namespace App\Http\Requests\EcoRefs\EmpPer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcoRefsEmpPerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required',
            'date' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'emp_per' => 'nullable|numeric',
        ];
    }
}
