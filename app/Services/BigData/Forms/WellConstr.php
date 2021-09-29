<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class WellConstr extends PlainForm
{
    protected $configurationFileName = 'well_constr';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('landing_date'),
            'dict.well',
            'drill_start_date'
        )) {
            $errors['landing_date'][] = trans('bd.validation.landing_date');
        }

        return $errors;
    }

}