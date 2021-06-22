<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OilPipesCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'ngdu_id' => 'nullable|numeric',
            'gu_id' => 'nullable|numeric',
            'zu_id' => 'nullable|numeric',
            'well_id' => 'nullable|numeric',
            'type_id' => 'nullable|numeric',
            'between_points' => 'nullable|string',
            'comment' => 'nullable|string',
            'start_point' => 'nullable|string',
            'end_point' => 'nullable|string',
            'material_id' => 'nullable|numeric',
        ];
    }
}
