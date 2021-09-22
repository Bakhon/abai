<?php

namespace App\Http\Requests\Economic\Gtm;

use Illuminate\Foundation\Http\FormRequest;

class EconomicGtmImportExcelRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
        ];
    }
}
