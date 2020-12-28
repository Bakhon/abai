<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class GuFilter extends BaseFilter
{

    public function __construct(Builder $query, array $params)
    {
        parent::__construct($query, $params);
        $this->defaultSortField = 'name';
        $this->defaultSortDesc = false;
    }

    protected function sort(string $field, bool $desc)
    {
        switch ($field) {
            case 'cdng':
                $this->query
                    ->select('gus.*')
                    ->leftJoin('cdngs', 'cdng.id', '=', 'gus.cdng_id')
                    //dirty hack for alphanumeric sort but other solutions doesn't work
                    ->addSelect(DB::raw('lpad(cdng.name, 10, 0) AS cdng_name'))
                    ->orderBy('cdng_name', $desc === true ? 'desc' : 'asc');
                break;
            case 'name':
                $this->query
                    ->select('gus.*')
                    ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gu_name'))
                    ->orderBy('gu_name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

}
