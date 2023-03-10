<?php

namespace App\Filters;

use Illuminate\Support\Facades\DB;

class PipeFilter extends BaseFilter
{
    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'gu':
                $this->query
                ->select('pipes.*')
                ->leftJoin('gus', 'gus.id', 'pipes.gu_id')
                //dirty hack for alphanumeric sort but other solutions doesn't work
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $isDescending ? 'desc' : 'asc');
                break;
            case 'material':
                $this->query
                    ->select('pipes.*')
                    ->leftJoin('materials', 'materials.id', 'pipes.material_id')
                    ->orderBy('materials.name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

}
