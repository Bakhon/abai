<?php


namespace App\Services\BigData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomValidator
{

    public function validate(Request $request, array $rules, array $errorNames, array $errors = [])
    {
        $errors = $this->getValidationErrors($request->all(), $rules, $errorNames, $errors);

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    public function validateSingleField(
        Request $request,
        array $rules,
        array $errorNames,
        string $field,
        array $errors = []
    ) {
        $errors = $this->getValidationErrors($request->all(), $rules, $errorNames, $errors);

        if (isset($errors[$field])) {
            throw ValidationException::withMessages($errors[$field]);
        }
    }

    public function isValidCoordinates($coord, $fieldId)
    {
        $pointInPolygon = (bool)DB::connection('tbd')
            ->table('tbdi.geo')
            ->whereRaw("'$coord' <@ allot_mining")
            ->where('id', $fieldId)
            ->count();

        return $pointInPolygon;
    }

    public function getValidationErrors(array $values, array $rules, array $errorNames, array $errors = []): array
    {
        $validator = Validator::make($values, $rules, [], $errorNames);
        return array_merge_recursive($errors, $validator->messages()->toArray());
    }
}