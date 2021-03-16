<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

abstract class PlainForm extends BaseForm
{
    abstract public function submit(): array;
}