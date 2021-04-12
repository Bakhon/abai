<?php


namespace App\Filters;

class OmgNGDUWellFilter extends BaseFilter
{
    protected $table = 'omg_n_g_d_u_wells';

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'zu':
                $this->query
                    ->select($this->table.'.*')
                    ->leftJoin('zus', 'zus.id', '=', $this->table.'.zu_id')
                    ->orderBy('zus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                    ->select($this->table.'.*')
                    ->leftJoin('wells', 'wells.id', '=', $this->table.'.well_id')
                    ->orderBy('wells.name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

}
