<?php

namespace App\Http\Requests\Economic\Analysis;

use Illuminate\Foundation\Http\FormRequest;

class EconomicAnalysisDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'kit_ids' => 'required|array|min:1',
            'kit_ids.*' => 'required_with:kit_ids|integer|min:1',
            'permanent_stop_coefficient' => 'required|numeric',
        ];
    }
}
