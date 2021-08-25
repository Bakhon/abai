<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;


class GeoStructure extends PlainForm
{
    protected $configurationFileName = 'geo_structure';

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDateDbeg(
            $this->request->get('well'),
            $this->request->get('dbeg'),
            'prod.well_geo',
            'dend',
            $this->request->get('id')
        )) {
            $errors['dbeg'] = trans('bd.validation.dbeg');
        }

        return $errors;
    }
}
