<?php

namespace App\Traits\BigData\Forms;

trait HasPlannedEvents
{
    protected function submitInnerTable(int $parentId)
    {
        $this->innerTableService->submitTables($this->request->get('well'), $this->tableFields);
    }
}