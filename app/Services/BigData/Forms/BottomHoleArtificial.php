<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class BottomHoleArtificial extends BottomHole
{
    protected $configurationFileName = 'bottom_hole_artificial';
    protected $bottomHoleType = 'HUD';

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('data'),
            'dict.well',
            'drill_end_date'
        )) {
            $errors['data'][] = trans('bd.validation.end_date');
        }

        return $errors;
    }

}
