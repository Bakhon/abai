<?php

namespace App\Filters;

class RoleFilter extends BaseFilter
{
    protected function sort(string $field, bool $desc)
    {
        $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
    }

}
