<?php

namespace App\Filters;

class MaterialFilter extends BaseFilter
{
    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'field':
                $this->query
                    ->select('materials.*')
                    ->leftJoin('fields', 'fields.id', 'materials.field_id')
                    ->orderBy('materials.name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

}
