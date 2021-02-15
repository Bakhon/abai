<?php


namespace App\Services\BigData;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomValidator
{

    public function validate($request, $rules, $errorNames, $errors)
    {
        $validator = Validator::make($request->all(), $rules, [], $errorNames);
        $errors = array_merge_recursive($errors, $validator->messages()->toArray());

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    public function isValidCoordinates($coord, $fieldId)
    {
        $pointInPolygon = (bool)DB::connection('tbd')
            ->table('dict.geo')
            ->whereRaw("'$coord' <@ allot_mining")
            ->where('id', $fieldId)
            ->count();

        return $pointInPolygon;
    }
}