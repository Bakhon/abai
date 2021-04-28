<?php

namespace App\Http\Requests\EcoRefs\Cost;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelEcoRefsCostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'file' => 'required|file|mimetypes:.xls,.xslx'
        ];
    }
}
