<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;

class WellRegister extends BaseForm
{
    protected $configurationFileName = 'well_register';

    public function submit(): array
    {
        $well = Well::create($this->request->all());
        return $well->toArray();
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidCoordinates('coord_mouth_x', 'coord_mouth_y')) {
            $errors['coord_mouth_x'][] = trans('bd.validation.coords_mouth');
            $errors['coord_mouth_y'][] = trans('bd.validation.coords_mouth');
        }

        if (!$this->isValidCoordinates('coord_bottom_x', 'coord_bottom_y')) {
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