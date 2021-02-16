<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DictionariesController extends Controller
{
    const DICTIONARIES = [
        'well_categories' => \App\Models\BigData\Dictionaries\WellCategory::class,
        'well_types' => \App\Models\BigData\Dictionaries\WellType::class,
        'companies' => \App\Models\BigData\Dictionaries\Company::class
    ];

    const TREE_DICTIONARIES = [
        'orgs' => \App\Models\BigData\Dictionaries\Org::class
    ];

    public function get(string $dict)
    {
        if (key_exists($dict, self::DICTIONARIES)) {
            return $this->getPlainDict($dict);
        } elseif (key_exists($dict, self::TREE_DICTIONARIES)) {
            return $this->getTreeDict($dict);
        }

        switch ($dict) {
            case 'geos':
                return $this->getGeoDict();
            default:
                return response()->json([], \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    private function generateTree($items): array
    {
        $new = [];
        foreach ($items as $item) {
            $new[$item['parent_id']][] = $item;
        }
        return $this->createTree($new, $new[null]);
    }

    private function createTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = $this->createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    private function getPlainDict(string $dict): array
    {
        return (self::DICTIONARIES[$dict])::query()
            ->select('id', 'name_ru as name')
            ->orderBy('name_ru', 'asc')
            ->get()
            ->toArray();
    }

    private function getTreeDict(string $dict): array
    {
        $items = (self::TREE_DICTIONARIES[$dict])::query()
            ->select('id', 'parent as parent_id', 'name_ru as label')
            ->orderBy('parent', 'asc')
            ->orderBy('name_ru', 'asc')
            ->get()
            ->toArray();

        return $this->generateTree($items);
    }

    private function getGeoDict(): array
    {
        $items = DB::connection('tbd')
            ->table('dict.geo as g')
            ->select('g.id', 'g.name_ru as label', 'gp.parent as parent_id')
            ->distinct()
            ->orderBy('parent_id', 'asc')
            ->orderBy('label', 'asc')
            ->leftJoin(
                'dict.geo_parent as gp',
                function ($join) {
                    $join->on('gp.geo_id', '=', 'g.id');
                    $join->on('gp.dbeg', '<=', DB::raw("NOW()"));
                    $join->on('gp.dend', '>=', DB::raw("NOW()"));
                }
            )
            ->get()
            ->map(function($item) {
                return (array)$item;
            })
            ->toArray();

        return $this->generateTree((array)$items);
    }
}
