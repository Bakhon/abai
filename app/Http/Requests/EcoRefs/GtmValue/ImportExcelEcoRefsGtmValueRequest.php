<?php

namespace App\Http\Requests\EcoRefs\GtmValue;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelEcoRefsGtmValueRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
        ];
    }
}
