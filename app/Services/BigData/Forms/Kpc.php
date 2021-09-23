<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class Kpc extends KrsPrs
{
    protected $configurationFileName = 'kpc';
    protected $repairType = 'CWO';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('td'))) {
            $errors['td'] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('hud'))) {
            $errors['hud'] = trans('bd.validation.depth');
        }

        return $errors;
    }
}