<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;
use App\Traits\BigData\Forms\DepthValidationTrait;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class BottomHole extends PlainForm
{
    protected $configurationFileName = 'bottom_hole';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;     
    
    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('data'), 'dict.well' , 'drill_start_date')) {
            $errors['data'][] = trans('bd.validation.bottom_hole_date');
        }

        return $errors;
    }

}