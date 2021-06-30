<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Http\JsonResponse;

class WellRegister extends PlainForm
{
    protected $configurationFileName = 'well_register';

    public function getResults(int $wellId): JsonResponse
    {
        return response()->json(
            [
                'rows' => [],
                'columns' => [],
                'form' => $this->params()
            ]
        );
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidCoordinates('whc.coord_point.x', 'whc.coord_point.y')) {
            $errors['coord_mouth_x'][] = trans('bd.validation.coords_mouth');
            $errors['coord_mouth_y'][] = trans('bd.validation.coords_mouth');
        }

        if (!$this->isValidCoordinates('bottom_coord.coord_point.x', 'bottom_coord.coord_point.y')) {
            $errors['coord_bottom_x'][] = trans('bd.validation.coords_bottom');
            $errors['coord_bottom_y'][] = trans('bd.validation.coords_bottom');
        }

        return $errors;
    }

    private function isValidCoordinates($coordXField, $coordYField): bool
    {
        if (!($this->request->filled(['geo', $coordXField, $coordYField]))) {
            return true;
        }

        $coord = "({$this->request->get($coordXField)},{$this->request->get($coordYField)})";

        return $this->validator->isValidCoordinates($coord, $this->request->get('geo'));
    }

}