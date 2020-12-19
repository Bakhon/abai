<?php


namespace App\Filters;

use Illuminate\Support\Facades\DB;

class OmgUHEFilter extends BaseFilter
{

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'field':
                $this->query
                ->select('omg_u_h_e_s.*')
                ->leftJoin('fields', 'fields.id', '=', 'omg_u_h_e_s.field_id')
                ->orderBy('fields.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'gu':
                $this->query
                ->select('omg_u_h_e_s.*')
                ->leftJoin('gus', 'gus.id', '=', 'omg_u_h_e_s.gu_id')
                //dirty hack for alphanumeric sort but other solutions doesn't work
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $desc === true ? 'desc' : 'asc');
                break;
            case 'zu':
                $this->query
                ->select('omg_u_h_e_s.*')
                ->leftJoin('zus', 'zus.id', '=', 'omg_u_h_e_s.zu_id')
                ->orderBy('zus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'ngdu':
                $this->query
                ->select('omg_u_h_e_s.*')
                ->leftJoin('ngdus', 'ngdus.id', '=', 'omg_u_h_e_s.ngdu_id')
                ->orderBy('ngdus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'cdng':
                $this->query
                ->select('omg_u_h_e_s.*')
                ->leftJoin('cdngs', 'cdngs.id', '=', 'omg_u_h_e_s.cdng_id')
                ->orderBy('cdngs.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                ->select('omg_u_h_e_s.*')
                ->leftJoin('wells', 'wells.id', '=', 'omg_u_h_e_s.well_id')
                ->orderBy('wells.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'inhibitor':
                $this->query
                ->select('omg_u_h_e_s.*')
                ->leftJoin('inhibitors', 'inhibitors.id', '=', 'omg_u_h_e_s.inhibitor_id')
                ->orderBy('inhibitors.name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

}
