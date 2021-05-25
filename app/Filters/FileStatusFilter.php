<?php

namespace App\Filters;

class FileStatusFilter extends BaseFilter
{
    protected function sort(string $field, bool $isDescending)
    {
        $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
    }

}
