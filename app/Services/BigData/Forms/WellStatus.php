<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class WellStatus extends PlainForm
{
    protected $configurationFileName = 'well_status';

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDateDbeg(
            $this->request->get('well'),
            $this->request->get('dbeg'),
            'prod.well_status',
            'dbeg',
            $this->request->get('id')
        )) {
            $errors['dbeg'] = trans('bd.validation.dbeg_well_block');
        }
        return $errors;
    }
}