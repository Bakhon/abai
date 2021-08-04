<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class WellTechChangeTech extends PlainForm
{
    protected $configurationFileName = 'well_tech_change_tech';

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('dbeg'), 'prod.well_tech', 'dbeg')) {
            $errors['dbeg'][] = trans('bd.validation.dbeg');
        }

        return $errors;
    }
}