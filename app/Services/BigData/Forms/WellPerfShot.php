<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class WellPerfShot extends WellPerf
{
    protected $configurationFileName = 'well_perf_shot';
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

    
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