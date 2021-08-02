<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class Gis extends PlainForm
{
    protected $configurationFileName = 'gis';
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;
    protected function getCustomValidationErrors(): array
    {
        $errors = [];
        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('matering_from'))) {
            $errors['matering_from'][] = trans('bd.validation.depth');
        }
        if (!$this->isValidDate($this->request->get('well'),$this->request->get('gis_date'),'dict.well' , 'drill_start_date')){
            $errors['gis_date'][] = trans('bd.validation.date');
        }
        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('process_from'))) {
            $errors['process_from'][] = trans('bd.validation.depth');
        }


        return $errors;
    }
}