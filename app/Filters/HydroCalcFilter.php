<?php


namespace App\Filters;

class HydroCalcFilter extends BaseFilter
{
    protected $table = 'trunkline_points';

    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }
}
