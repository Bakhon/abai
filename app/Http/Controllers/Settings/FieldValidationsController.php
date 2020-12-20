<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\FieldValidationUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FieldValidationsController extends Controller
{
    public function index()
    {
        $fields = \App\Models\CrudFieldSettings::query()
            ->get()
            ->groupBy('section');

        return view('settings.fields', compact('fields'));
    }

    public function update(FieldValidationUpdateRequest $request)
    {
        foreach ($request->fields as $fieldData) {
            \App\Models\CrudFieldSettings::find($fieldData['id'])
                ->update(
                    [
                        'min_value' => $fieldData['min_value'],
                        'max_value' => $fieldData['max_value'],
                    ]
                );
        }
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
