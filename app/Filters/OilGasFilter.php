<?php


namespace App\Filters;

use Illuminate\Support\Facades\DB;

class OilGasFilter extends BaseFilter
{

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'other_objects':
                $this->query
                ->select('oil_gases.*')
                ->leftJoin('other_objects', 'other_objects.id', '=', 'oil_gases.other_objects_id')
                ->orderBy('other_objects.name', $desc ? 'desc' : 'asc');
                break;
            case 'gu':
                $this->query
                ->select('oil_gases.*')
                ->leftJoin('gus', 'gus.id', '=', 'oil_gases.gu_id')
                //dirty hack for alphanumeric sort but other solutions doesn't work
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $desc ? 'desc' : 'asc');
                break;
            case 'zu':
                $this->query
                ->select('oil_gases.*')
                ->leftJoin('zus', 'zus.id', '=', 'oil_gases.zu_id')
                ->orderBy('zus.name', $desc ? 'desc' : 'asc');
                break;
            case 'ngdu':
                $this->query
                ->select('oil_gases.*')
                ->leftJoin('ngdus', 'ngdus.id', '=', 'oil_gases.ngdu_id')
                ->orderBy('ngdus.name', $desc ? 'desc' : 'asc');
                break;
            case 'cdng':
                $this->query
                ->select('oil_gases.*')
                ->leftJoin('cdngs', 'cdngs.id', '=', 'oil_gases.cdng_id')
                ->orderBy('cdngs.name', $desc ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                ->select('oil_gases.*')
                ->leftJoin('wells', 'wells.id', '=', 'oil_gases.well_id')
                ->orderBy('wells.name', $desc ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc ? 'desc' : 'asc');
        }
    }

}
