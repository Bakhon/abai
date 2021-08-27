<?php

namespace App\Http\Requests\EcoRefs\EmpPer;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelEcoRefsEmpPerRequest extends FormRequest
{
    const MIME_TYPES = '.xls,.xlsx';


    public function rules()
    {
        return [
            'file' => 'required|file|mimes:' . str_replace('.', '', self::MIME_TYPES),
        ];
    }
}
