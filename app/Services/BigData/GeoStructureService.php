<?php


namespace App\Services\BigData;

use Illuminate\Support\Facades\DB;

class GeoStructureService extends StructureService
{

    public function getGeoTreeWithPermissions(array $types)
    {
        $items = DB::connection('tbd')
            ->table('dict.geo as g')
            ->selectRaw('g.id, g.name_ru as name, gp.parent as parent_id, gt.code as sub_type')
            ->whereIn('gt.code', $this->getSubTypes('geo', $types))
            ->distinct()
            ->orderBy('parent_id')
            ->orderBy('name')
            ->leftJoin(
                'dict.geo_parent as gp',
                function ($join) {
                    $join->on('gp.geo', '=', 'g.id');
                    $join->on('gp.dbeg', '<=', DB::raw("NOW()"));
                    $join->on('gp.dend', '>=', DB::raw("NOW()"));
                }
            )
            ->leftJoin('dict.geo_type as gt', 'g.geo_type', 'gt.id')
            ->get()
            ->map(
                function ($item) {
                    $item = (array)$item;
                    $item['type'] = 'geo';
                    return $item;
                }
            )
            ->toArray();

        $tree = $this->generateTree($items);
        return $this->fillTreeWithFullNames($tree);
    }
}