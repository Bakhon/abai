<?php

namespace App\Http\Requests\EcoRefs\TarifyTn;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcoRefsTarifyTnRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sc_fa' => 'required',
            'branch_id' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'route_tn_id' => 'required',
            'exc_id' => 'required',
            'date' => 'required',
            'tn_rate' => 'required',
        ];
    }
}
