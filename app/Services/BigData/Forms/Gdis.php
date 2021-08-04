<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class Gdis extends PlainForm
{
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;
    protected $configurationFileName = 'gdis';
    protected function getCustomValidationErrors(): array
    {
        $errors = [];
        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }
        
        return $errors;
    }
}



