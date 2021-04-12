<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CorrosionFilter extends BaseFilter
{

    public function __construct(Builder $query, array $params)
    {
        parent::__construct($query, $params);
        $this->defaultSortField = 'final_date_of_background_corrosion';
    }

    protected function sort(string $field, bool $desc)
    {
        switch($field) {
            case 'field':
                $this->query
                ->select('corrosions.*')
                ->leftJoin('fields', 'fields.id', '=', 'corrosions.field_id')
                ->orderBy('fields.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'gu':
                $this->query
                ->select('corrosions.*')
                ->leftJoin('gus', 'gus.id', '=', 'corrosions.gu_id')
                //dirty hack for alphanumeric sort but other solutions doesn't work
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $desc === true ? 'desc' : 'asc');
                break;
            case 'zu':
                $this->query
                ->select('corrosions.*')
                ->leftJoin('zus', 'zus.id', '=', 'corrosions.zu_id')
                ->orderBy('zus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'ngdu':
                $this->query
                ->select('corrosions.*')
                ->leftJoin('ngdus', 'ngdus.id', '=', 'corrosions.ngdu_id')
                ->orderBy('ngdus.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'cdng':
                $this->query
                ->select('corrosions.*')
                ->leftJoin('cdngs', 'cdngs.id', '=', 'corrosions.cdng_id')
                ->orderBy('cdngs.name', $desc === true ? 'desc' : 'asc');
                break;
            case 'well':
                $this->query
                ->select('corrosions.*')
                ->leftJoin('wells', 'wells.id', '=', 'corrosions.well_id')
                ->orderBy('wells.name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

    protected function filter_start_date_of_background_corrosion($dates)
    {
        $this->filterByDate($dates, 'start_date_of_background_corrosion');
    }

    protected function filter_final_date_of_background_corrosion($dates)
    {
        $this->filterByDate($dates, 'final_date_of_background_corrosion');
    }

    protected function filter_start_date_of_corrosion_velocity_with_inhibitor_measure($dates)
    {
        $this->filterByDate($dates, 'start_date_of_corrosion_velocity_with_inhibitor_measure');
    }

    protected function filter_final_date_of_corrosion_velocity_with_inhibitor_measure($dates)
    {
        $this->filterByDate($dates, 'final_date_of_corrosion_velocity_with_inhibitor_measure');
    }

}
