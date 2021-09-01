<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DepthValidationTrait;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
class WellPerfStab extends PlainForm
{
    protected $configurationFileName = 'well_perf_stab';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;
    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('base'))) {
            $errors['base'] = trans('bd.validation.depth');
        }
        if (!$this->isValidDate($this->request->get('well'), $this->request->get('perf_date'), 'dict.well' , 'drill_end_date')) {
            $errors['perf_date'] = trans('bd.validation.perf_date');
        }

        return $errors;
    }
}