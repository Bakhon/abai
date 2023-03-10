<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\FieldValidationUpdateRequest;
use Illuminate\Http\Response;
use App\Models\CrudFieldSettings;

class FieldValidationsController extends Controller
{
    public function index()
    {
        $fields = CrudFieldSettings::query()
            ->get()
            ->groupBy('section');

        return view('settings.fields', compact('fields'));
    }

    public function update(FieldValidationUpdateRequest $request)
    {
        foreach ($request->fields as $fieldData) {
            CrudFieldSettings::find($fieldData['id'])
                ->update(
                    [
                        'min_value' => $fieldData['min_value'],
                        'max_value' => $fieldData['max_value'],
                    ]
                );
        }
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getValidationParams ($section): \Symfony\Component\HttpFoundation\Response
    {
        $validationParams = CrudFieldSettings::query()
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

        return response()->json($validationParams);
    }
}
