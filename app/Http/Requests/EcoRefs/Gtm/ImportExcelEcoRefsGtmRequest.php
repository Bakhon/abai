<?php

namespace App\Http\Requests\EcoRefs\Gtm;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelEcoRefsGtmRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
        ];
    }
}
