<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class Prs extends KrsPrs
{
    protected $configurationFileName = 'prs';
    protected $repairType = 'WLO';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('actual_bh'))) {
            $errors['actual_bh'] = trans('bd.validation.depth');
        }

        return $errors;
    }
}