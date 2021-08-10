<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ZuFilter extends BaseFilter
{

    public function __construct(Builder $query, array $params)
    {
        parent::__construct($query, $params);
        $this->defaultSortField = 'name';
        $this->defaultSortDesc = false;
    }

    protected function sort(string $field, bool $isDescending)
    {
        switch ($field) {
            case 'name':
                $this->query
                    ->select('zus.*')
                    ->addSelect(DB::raw('lpad(zus.name, 10, 0) AS zu_name'))
                    ->orderBy('zu_name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }

}
