<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class WellTechChangeTap extends PlainForm
{
    protected $configurationFileName = 'well_tech_change_tap';

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('dbeg'), 'prod.well_tech', 'dend')) {
            $errors['dbeg'][] = trans('bd.validation.dbeg');
        }

        return $errors;
    }
}