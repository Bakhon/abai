<?php

namespace App\Http\Requests\EcoRefs\Cost;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcoRefsCostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required',
            'company_id' => 'required',
            'date' => 'required',
            'variable' => 'nullable|numeric',
            'fix_noWRpayroll' => 'nullable|numeric',
            'fix_nopayroll' => 'nullable|numeric',
            'fix' => 'nullable|numeric',
            'gaoverheads' => 'nullable|numeric',
            'wr_nopayroll' => 'nullable|numeric',
            'wr_payroll' => 'nullable|numeric',
            'wo' => 'nullable|numeric',
            'net_back' => 'nullable|numeric',
            'amort' => 'nullable|numeric',
        ];
    }
}
