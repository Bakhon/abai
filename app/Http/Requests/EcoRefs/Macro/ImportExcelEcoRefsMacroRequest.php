<?php

namespace App\Http\Requests\EcoRefs\Macro;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelEcoRefsMacroRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';


    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
        ];
    }
}
