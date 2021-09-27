<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class OrgStructure extends PlainForm
{
    protected $configurationFileName = 'org_structure';

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDateDbeg(
            $this->request->get('well'),
            $this->request->get('dbeg'),
            'prod.well_org',
            'dend',
            $this->request->get('id')
        )) {
            $errors['dbeg'] = trans('bd.validation.dbeg');
        }

        return $errors;
    }
}