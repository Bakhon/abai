<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Collection;

abstract class TableForm extends BaseForm
{

    protected $rowsPerPage = 20;

    abstract public function getRows();

    abstract public function saveSingleField(string $field);

    protected function getFieldByCode(string $code)
    {
        return $this->getFields()->where('code', $code)->first();
    }

    protected function getFilterTree(): array
    {
        return [];
    }

    protected function getFields(): Collection
    {
        return collect($this->params()['columns']);
    }

    public function getFormatedParams(): array
    {
        return [
            'params' => $this->params(),
            'fields' => $this->getFields()->pluck('', 'code')->toArray(),
            'filterTree' => $this->getFilterTree()
        ];
    }
}