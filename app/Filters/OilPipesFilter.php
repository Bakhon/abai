<?php


namespace App\Filters;

use Illuminate\Support\Facades\DB;

class OilPipesFilter extends BaseFilter
{

    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'gu':
                $this->query
                ->select('oil_pipes.*')
                ->leftJoin('gus', 'gus.id', 'oil_gases.gu_id')
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $isDescending ? 'desc' : 'asc');
                break;
            case 'zu':
                $this->query
                ->select('oil_pipes.*')
                ->leftJoin('zus', 'zus.id', 'oil_gases.zu_id')
                ->orderBy('zus.name', $isDescending ? 'desc' : 'asc');
                break;
            case 'ngdu':
                $this->query
                ->select('oil_pipes.*')
                ->leftJoin('ngdus', 'ngdus.id', 'oil_gases.ngdu_id')
                ->orderBy('ngdus.name', $isDescending ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                ->select('oil_pipes.*')
                ->leftJoin('wells', 'wells.id', 'oil_gases.well_id')
                ->orderBy('wells.name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

}
