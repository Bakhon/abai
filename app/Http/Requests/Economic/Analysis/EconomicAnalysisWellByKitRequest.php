<?php

namespace App\Http\Requests\Economic\Analysis;

use Illuminate\Foundation\Http\FormRequest;

class EconomicAnalysisWellByKitRequest extends FormRequest
{
    public function rules()
    {
        return [
            'permanent_stop_coefficient' => 'required|numeric',
            'kit_id' => 'required|integer|min:1',
        ];
    }
}
