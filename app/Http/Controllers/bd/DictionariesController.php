<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DictionariesController extends Controller
{
    const DICTIONARIES = [
        'well_categories' => \App\Models\BigData\Dictionaries\WellCategory::class,
        'well_types' => \App\Models\BigData\Dictionaries\WellType::class,
        'companies' => \App\Models\BigData\Dictionaries\Company::class
    ];

    const TREE_DICTIONARIES = [
        'orgs' => \App\Models\BigData\Dictionaries\Org::class,
        'geos' => \App\Models\BigData\Dictionaries\Geo::class
    ];

    public function get(string $dict)
    {
        if (key_exists($dict, self::DICTIONARIES)) {
            return (self::DICTIONARIES[$dict])::orderBy('name', 'asc')->get();
        }
        elseif (key_exists($dict, self::TREE_DICTIONARIES)) {
            $items = (self::TREE_DICTIONARIES[$dict])::query()
                ->select('id', 'parent_id', 'name as label')
                ->orderBy('parent_id', 'asc')
                ->orderBy('name', 'asc')
                ->get()
                ->toArray();
            return $this->generateTree($items);
        }
        return response()->json([], \Illuminate\Http\Response::HTTP_NOT_FOUND);
    }

    private function generateTree($items)
    {
        $new = [];
        foreach ($items as $item){
            $new[$item['parent_id']][] = $item;
        }
        return $this->createTree($new, $new[null]);
    }

    private function createTree(&$list, $parent){
        $tree = array();
        foreach ($parent as $k=>$l){
            if(isset($list[$l['id']])){
                $l['children'] = $this->createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }
}
