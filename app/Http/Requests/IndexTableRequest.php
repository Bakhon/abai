<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexTableRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'query' => 'nullable|string',
            'order_by' => 'nullable|string',
            'order_desc' => 'nullable|boolean',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'filter' => 'nullable|array',
            'date' => 'nullable|date',
            'page' => 'nullable|int',
            'calc_export' => 'nullable|string',
            'model_name' => 'nullable|string',
            'gu_id' => 'nullable|int',
            'gu_ids' => 'nullable|array'
        ];
    }
}
