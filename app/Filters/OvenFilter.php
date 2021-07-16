<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OvenFilter extends BaseFilter
{

    public function __construct(Builder $query, array $params)
    {
        parent::__construct($query, $params);
        $this->defaultSortField = 'date_of_exploitation';
    }

    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'gu_id':
                $this->query
                ->select('ovens.*')
                ->leftJoin('gus', 'gus.id', 'ovens.gu_id')
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

    protected function filter_date_of_exploitation($dates)
    {
        $this->filterByDate($dates, 'date_of_exploitation');
    }

    protected function filter_date_of_repair($dates)
    {
        $this->filterByDate($dates, 'date_of_repair');
    }

}