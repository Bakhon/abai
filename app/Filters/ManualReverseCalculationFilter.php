<?php


namespace App\Filters;

class ManualReverseCalculationFilter extends BaseFilter
{
    protected function sort(string $field, bool $isDescending)
    {
        $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
    }
}
