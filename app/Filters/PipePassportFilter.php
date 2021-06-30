<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class PipePassportFilter extends BaseFilter
{

    public function __construct(Builder $query, array $params)
    {
        parent::__construct($query, $params);
        $this->defaultSortField = 'id';
        $this->defaultSortDesc = false;
    }

    protected function sort(string $field, bool $isDescending)
    {
        $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
    }

    protected function filter_installation_date($dates)
    {
        $this->filterByDate($dates, 'installation_date');
    }

}
