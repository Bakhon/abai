<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ZusCleaningFilter extends BaseFilter
{

    public function __construct(Builder $query, array $params)
    {
        parent::__construct($query, $params);
        $this->defaultSortField = 'date';
    }

    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'zu_id':
                $this->query
                ->select('zu_cleanings.*')
                ->leftJoin('zus', 'zus.id', 'zu_cleanings.zu_id')
                ->addSelect(DB::raw('lpad(zus.name, 10, 0) AS zus_name'))
                ->orderBy('zus_name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

    protected function filter_date($dates)
    {
        $this->filterByDate($dates, 'date');
    }

}