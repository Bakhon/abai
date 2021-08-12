<?php


namespace App\Filters;

class OmgNGDUZuFilter extends BaseFilter
{
    protected $table = 'omg_n_g_d_u_zus';

    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'zu':
                $this->query
                    ->select($this->table.'.*')
                    ->leftJoin('zus', 'zus.id', $this->table.'.zu_id')
                    ->orderBy('zus.name', $isDescending ? 'desc' : 'asc');
                break;

                default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

}
