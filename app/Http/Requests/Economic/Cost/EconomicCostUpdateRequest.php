<?php

namespace App\Http\Requests\Economic\Cost;

use Illuminate\Foundation\Http\FormRequest;

class EconomicCostUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required|integer|min:1',
            'company_id' => 'required|integer|min:1',
            'date' => 'required',
            'variable' => 'nullable|numeric',
            'variable_processing' => 'nullable|numeric',
            'fix_noWRpayroll' => 'nullable|numeric',
            'fix_nopayroll' => 'nullable|numeric',
            'fix' => 'nullable|numeric',
            'gaoverheads' => 'nullable|numeric',
            'wr_nopayroll' => 'nullable|numeric',
            'wr_payroll' => 'nullable|numeric',
            'wo' => 'nullable|numeric',
            'net_back' => 'nullable|numeric',
            'amort' => 'nullable|numeric',
            'pes_id' => 'nullable|integer|min:1'
        ];
    }
}
