<?php


namespace App\Filters;

use Illuminate\Support\Facades\DB;

class OmgNGDUFilter extends BaseFilter
{
    protected $table = 'omg_n_g_d_u_s_1';

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'field':
                $this->query
                ->select($this->table.'.*')
                ->leftJoin('fields', 'fields.id', '=', $this->table.'.field_id')
                ->orderBy('fields.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'gu':
                $this->query
                ->select($this->table.'.*')
                ->leftJoin('gus', 'gus.id', '=', $this->table.'.gu_id')
                //dirty hack for alphanumeric sort but other solutions doesn't work
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $desc === true ? 'desc' : 'asc');
                break;
            case 'zu':
                $this->query
                ->select($this->table.'.*')
                ->leftJoin('zus', 'zus.id', '=', $this->table.'.zu_id')
                ->orderBy('zus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'ngdu':
                $this->query
                ->select($this->table.'.*')
                ->leftJoin('ngdus', 'ngdus.id', '=', $this->table.'.ngdu_id')
                ->orderBy('ngdus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'cdng':
                $this->query
                ->select($this->table.'.*')
                ->leftJoin('cdngs', 'cdngs.id', '=', $this->table.'.cdng_id')
                ->orderBy('cdngs.name', $desc === true ? 'desc' : 'asc');
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

//    protected function filter_date($dates)
//    {
//        $this->filterByDate($dates, 'date');
//    }

}
