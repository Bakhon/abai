<?php

namespace App\Http\Requests\Economic\Cost;

use Illuminate\Foundation\Http\FormRequest;

class EconomicCostImportExcelRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';

    protected function prepareForValidation()
    {
        $this['is_forecast'] = (bool)request()->input('is_forecast');
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
            'is_forecast' => 'nullable|boolean'
        ];
    }
}
