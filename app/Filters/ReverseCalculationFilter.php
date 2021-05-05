<?php


namespace App\Filters;

class ReverseCalculationFilter extends BaseFilter
{
    protected function sort(string $field, bool $isDescending)
    {
        $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
    }
}
