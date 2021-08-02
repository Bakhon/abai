<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WellPerfShot extends PlainForm
{
    protected $configurationFileName = 'well_perf_shot';
    use DepthValidationTrait;
    

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('base'))) {
            $errors['base'][] = trans('bd.validation.depth');
        }

        return $errors;
    }
}