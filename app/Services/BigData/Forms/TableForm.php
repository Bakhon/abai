<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

abstract class TableForm extends BaseForm
{
    protected function getFields(): \Illuminate\Support\Collection
    {
        return collect($this->params()['fields']);
    }
}