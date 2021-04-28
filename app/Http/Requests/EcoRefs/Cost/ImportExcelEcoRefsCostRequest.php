<?php

namespace App\Http\Requests\EcoRefs\Cost;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelEcoRefsCostRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
            'is_fact' => 'nullable|boolean'
        ];
    }
}
