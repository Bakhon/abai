<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DepthValidationTrait;
class WellPerfBridgePlug extends PlainForm
{
    protected $configurationFileName = 'well_perf_bridge_plug';
    use DepthValidationTrait;
    

    protected function getCustomValidationErrors(): array
    {
        $errors = [];


        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        return $errors;
    }

}