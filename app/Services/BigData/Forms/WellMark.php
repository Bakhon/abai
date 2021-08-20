<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
class WellMark extends PlainForm
{
    protected $configurationFileName = 'well_mark';
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'),$this->request->get('dbeg'),'dict.well' ,'drill_start_date')) 
        {
            $errors['dbeg'] = trans('bd.validation.date');
        }

        return $errors;
    }
}