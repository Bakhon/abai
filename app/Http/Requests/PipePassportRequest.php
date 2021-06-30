<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PipePassportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ngdu' => 'required|exists:ngdus,name',
            'cdng' => 'required|exists:cdngs,name',
            "installation_date" => 'nullable|date',
            'field' => 'nullable|string',
            'name' => 'nullable|string',
            'main_reserved' => 'nullable|string',
            'from' => 'nullable|string',
            'to' => 'nullable|string',
            'length' => 'nullable|string',
            'diameter' => 'nullable|string',
            'thickness' => 'nullable|string',
            'material' => 'nullable|string',
            'condition' => 'nullable|string',
            'gusts' => 'nullable|string',
            'data_sheet' => 'nullable|numeric',
            'used' => 'nullable|numeric',
            'comment' => 'nullable|string'
        ];
    }
}
