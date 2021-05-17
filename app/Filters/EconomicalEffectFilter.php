<?php


namespace App\Filters;

use Illuminate\Support\Facades\DB;

class EconomicalEffectFilter extends BaseFilter
{

    protected function sort(string $field, bool $isDescending)
    {
        switch($field) {
            case 'gu':
                $this->query
                ->select('omg_u_h_e_s.*')
                ->leftJoin('gus', 'gus.id', 'omg_u_h_e_s.gu_id')
                ->addSelect(DB::raw('lpad(gus.name, 10, 0) AS gus_name'))
                ->orderBy('gus_name', $isDescending ? 'desc' : 'asc');
                break;
            default:
                $this->query->orderBy($field, $isDescending ? 'desc' : 'asc');
        }
    }
}
