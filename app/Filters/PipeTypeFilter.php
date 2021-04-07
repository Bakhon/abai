<?php

namespace App\Filters;

class PipeTypeFilter extends BaseFilter
{
    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'material':
                $this->query
                    ->select('pipe_types.*')
                    ->leftJoin('materials', 'materials.id', 'pipe_types.material_id')
                    ->orderBy('materials.name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

}
