<?php


namespace App\Filters;

class OmgNGDUWellFilter extends BaseFilter
{
    protected $table = 'omg_n_g_d_u_wells';

    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'zu':
                $this->query
                    ->select($this->table.'.*')
                    ->leftJoin('zus', 'zus.id', $this->table.'.zu_id')
                    ->orderBy('zus.name', $isDescending ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                    ->select($this->table.'.*')
                    ->leftJoin('wells', 'wells.id', $this->table.'.well_id')
                    ->orderBy('wells.name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

}
