<?php


namespace App\Filters;

class OmgNGDUFilter extends BaseFilter
{

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'gu':
                $this->query
                ->join('gus', 'gus.id', '=', 'omg_n_g_d_u_s.gu_id')
                ->orderBy('gus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'zu':
                $this->query
                ->join('zus', 'zus.id', '=', 'omg_n_g_d_u_s.zu_id')
                ->orderBy('zus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'ngdu':
                $this->query
                ->join('ngdus', 'ngdus.id', '=', 'omg_n_g_d_u_s.ngdu_id')
                ->orderBy('ngdus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'cdng':
                $this->query
                ->join('cdngs', 'cdngs.id', '=', 'omg_n_g_d_u_s.cdng_id')
                ->orderBy('cdngs.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                ->join('wells', 'wells.id', '=', 'omg_n_g_d_u_s.well_id')
                ->orderBy('wells.name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

}
