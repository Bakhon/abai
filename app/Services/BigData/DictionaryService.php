<?php


namespace App\Services\BigData;

use App\Exceptions\DictionaryNotFound;
use App\Models\BigData\Dictionaries\Company;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\WellCategory;
use App\Models\BigData\Dictionaries\WellType;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\DB;

class DictionaryService
{
    const DICTIONARIES = [
        'well_categories' => WellCategory::class,
        'well_types' => WellType::class,
        'companies' => Company::class
    ];

    const TREE_DICTIONARIES = [
        'orgs' => Org::class
    ];

    const CACHE_TTL = 60;

    protected $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function get(string $dict)
    {
        $cacheKey = 'bd_dict_' . $dict;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        if (key_exists($dict, self::DICTIONARIES)) {
            $dict = $this->getPlainDict($dict);
        } elseif (key_exists($dict, self::TREE_DICTIONARIES)) {
            $dict = $this->getTreeDict($dict);
        } else {
            switch ($dict) {
                case 'geos':
                    $dict = $this->getGeoDict();
                    break;
                default:
                    throw new DictionaryNotFound();
            }
        }

        $this->cache->set($cacheKey, $dict, \Carbon\Carbon::now()->addMinutes(self::CACHE_TTL));
        return $dict;
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
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();

        return $this->generateTree((array)$items);
    }
}