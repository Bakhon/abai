<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\DepthValidationTrait;
use App\Http\Controllers\Traits\DateValidationTrait;

class BottomHoleArtificial extends PlainForm
{
    protected $configurationFileName = 'bottom_hole_artificial';

    use DepthValidationTrait;
    use DateValidationTrait;
        
    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('data'), 'dict.well' , 'drill_end_date')) {
            $errors[$this->request->get('data')][] = trans('bd.validation.end_date');
        }

        return $errors;
    }

}


