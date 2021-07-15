<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DepthValidationTrait;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class WellPerf extends PlainForm
{
    protected $configurationFileName = 'well_perf';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('base'))) {
            $errors['base'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('data'), 'dict.well' , 'drill_end_date')) {
            $errors[$this->request->get('data')][] = trans('bd.validation.perf_date');
        }

        return $errors;
    }
}