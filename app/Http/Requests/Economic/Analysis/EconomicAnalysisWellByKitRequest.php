<?php

namespace App\Http\Requests\Economic\Analysis;

use Illuminate\Foundation\Http\FormRequest;

class EconomicAnalysisWellByKitRequest extends FormRequest
{
    public function rules()
    {
        return [
            'permanent_stop_coefficient' => 'required|numeric',
            'kit_ids' => 'required|array|min:1',
            'kit_ids.*' => 'required_with:kit_ids|integer|min:1',
        ];
    }
}
