<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class WellExpl extends PlainForm
{
    protected $configurationFileName = 'well_expl';

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDateDbeg($this->request->get('well'),$this->request->get('dbeg'), 'prod.well_expl', 'dbeg')){
            $errors['dbeg'] = trans('bd.validation.dbeg_well_block');
        }

        return $errors;
    }
}