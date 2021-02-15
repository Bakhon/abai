<?php

namespace App\Http\Requests\BigData;

use Illuminate\Foundation\Http\FormRequest;

class WellCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => 'required|max:255',
            "date_create" => 'required|date',
            "category" => 'required|numeric',
            "org" => 'required|numeric',
            "geo" => 'required|numeric',
            "altitude" => 'nullable|numeric',
            "rotor_table" => 'nullable|numeric',
            "coord_mouth_x" => 'nullable|numeric',
            "coord_mouth_y" => 'nullable|numeric',
            "type" => 'required|numeric',
            "coord_bottom_x" => 'nullable|numeric',
            "coord_bottom_y" => 'nullable|numeric',
            "date_start_drilling" => 'nullable|date',
            "date_end_drilling" => 'nullable|date',
            "company" => 'nullable|numeric',
            "agreement_num" => 'required|max:255',
            "agreement_date" => 'required|date',
            "planned_depth" => 'nullable|numeric',
            "avg_gasoil_ratio" => 'nullable|numeric',
            "planned_liquid_rate" => 'nullable|numeric',
            "planned_watering" => 'nullable|numeric',
        ];
    }
}
