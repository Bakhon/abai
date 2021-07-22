<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;
use App\Traits\BigData\Forms\DepthValidationTrait;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;

class WellConstr extends PlainForm
{
    protected $configurationFileName = 'well_constr';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;
           
    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors[$this->request->get('depth')][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('landing_date'),'dict.well' , 'drill_start_date')) {
            $errors[$this->request->get('landing_date')][] = trans('bd.validation.landing_date');
        }

        return $errors;
    }

}