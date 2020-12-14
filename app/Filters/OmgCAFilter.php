<?php


namespace App\Filters;

class OmgCAFilter extends BaseFilter
{

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'gu':
                $this->query
                ->join('gus', 'gus.id', '=', 'omg_c_a_s.gu_id')
                ->orderBy('gus.name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

}
