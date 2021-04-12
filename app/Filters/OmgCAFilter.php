<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OmgCAFilter extends BaseFilter
{

    public function __construct(Builder $query, array $params)
    {
        parent::__construct($query, $params);
        $this->defaultSortField = 'created_at';
    }

    protected function sort(string $field, bool $desc)
    {
        switch ($field) {
            case 'gu':
                $this->query
                    ->select('omg_c_a_s.*')
                    ->leftJoin('gus', 'gus.id', '=', 'omg_c_a_s.gu_id')
                    //dirty hack for alphanumeric sort but other solutions doesn't work
                    ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                    ->orderBy('gus_name', $desc === true ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $desc === true ? 'desc' : 'asc');
        }
    }

    protected function filter_date($date)
    {
        $this->query->where('date', 'LIKE', $date . '%');
    }

}
