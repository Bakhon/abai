<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Collection;

abstract class TableForm extends BaseForm
{

    protected $rowsPerPage = 20;

    abstract protected function getRows();

    abstract protected function getColumns();

    protected function getFields(): Collection
    {
        return collect($this->params()['fields']);
    }

    public function getFormatedParams(): array
    {
        return [
            'params' => $this->params(),
            'fields' => $this->getFields()->pluck('', 'code')->toArray(),
            'columns' => $this->getColumns(),
            'rows' => $this->getRows()
        ];
    }
}