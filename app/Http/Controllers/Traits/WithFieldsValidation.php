<?php

namespace App\Http\Controllers\Traits;

use App\Models\CrudFieldSettings;

trait WithFieldsValidation
{
    protected function getValidationParams($section) {
        return CrudFieldSettings::query()
            ->where('section', $section)
            ->get()
            ->keyBy('field_code')
            ->map(function($field){
                return [
                    'min' => $field->min_value,
                    'max' => $field->max_value,
                ];
            })
            ->toArray();
    }

    protected function validateFields(\Illuminate\Foundation\Http\FormRequest $request, string $section)
    {
        $validationRules = [];

        $fieldsValidation = CrudFieldSettings::query()
            ->where('section', $section)
            ->get();

        foreach($fieldsValidation as $field) {
            $validationRules[$field->field_code] = [
                'nullable',
                'numeric',
                'min:'.$field->min_value,
                'max:'.$field->max_value
            ];
        }

        $request->validate($validationRules);
    }
}