<?php

namespace App\Http\Requests\Paegtm\EcoRefs;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelGtmFactCostsRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
        ];
    }
}
