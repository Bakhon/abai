<?php

namespace App\Http\Requests\Economic\Technical;

use Illuminate\Foundation\Http\FormRequest;

class TechnicalDataForecastImportExcelRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
        ];
    }
}
