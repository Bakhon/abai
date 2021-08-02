<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DepthValidationTrait;

class WellPerfStab extends PlainForm
{
    protected $configurationFileName = 'well_perf_stab';
    use DepthValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('base'))) {
            $errors['base'][] = trans('bd.validation.depth');
        }

        return $errors;
    }
}