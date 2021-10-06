<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class WellPerfStab extends WellPerf
{
    protected $configurationFileName = 'well_perf_stab';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('base'))) {
            $errors['base'] = trans('bd.validation.depth');
        }
        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('perf_date'),
            'dict.well',
            'drill_end_date'
        )) {
            $errors['perf_date'] = trans('bd.validation.perf_date');
        }

        return $errors;
    }
}