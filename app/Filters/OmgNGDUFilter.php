<?php


namespace App\Filters;

use Illuminate\Support\Facades\DB;

class OmgNGDUFilter extends BaseFilter
{

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'field':
                $this->query
                ->select('omg_n_g_d_u_s.*')
                ->leftJoin('fields', 'fields.id', '=', 'omg_n_g_d_u_s.field_id')
                ->orderBy('fields.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'gu':
                $this->query
                ->select('omg_n_g_d_u_s.*')
                ->leftJoin('gus', 'gus.id', '=', 'omg_n_g_d_u_s.gu_id')
                //dirty hack for alphanumeric sort but other solutions doesn't work
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $desc === true ? 'desc' : 'asc');
                break;
            case 'zu':
                $this->query
                ->select('omg_n_g_d_u_s.*')
                ->leftJoin('zus', 'zus.id', '=', 'omg_n_g_d_u_s.zu_id')
                ->orderBy('zus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'ngdu':
                $this->query
                ->select('omg_n_g_d_u_s.*')
                ->leftJoin('ngdus', 'ngdus.id', '=', 'omg_n_g_d_u_s.ngdu_id')
                ->orderBy('ngdus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'cdng':
                $this->query
                ->select('omg_n_g_d_u_s.*')
                ->leftJoin('cdngs', 'cdngs.id', '=', 'omg_n_g_d_u_s.cdng_id')
                ->orderBy('cdngs.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                ->select('omg_n_g_d_u_s.*')
                ->leftJoin('wells', 'wells.id', '=', 'omg_n_g_d_u_s.well_id')
                ->orderBy('wells.name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

}
