<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\HasPlannedEvents;

class InjectionWells extends PlainForm
{
    use DateMoreThanValidationTrait;
    use HasPlannedEvents;

    protected $configurationFileName = 'injection_wells';

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDateDbeg(
            $this->request->get('well'),
            $this->request->get('dbeg'),
            'prod.tech_mode_inj',
            'dend',
            $this->request->get('id')
        )) {
            $errors['dbeg'] = trans('bd.validation.dbeg');
        }

        return $errors;
    }

}