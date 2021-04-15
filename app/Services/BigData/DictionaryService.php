<?php


namespace App\Services\BigData;

use App\Exceptions\DictionaryNotFound;
use App\Models\BigData\Dictionaries\Company;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\WellCategory;
use App\Models\BigData\Dictionaries\WellType;
use App\Models\BigData\Dictionaries\Equip;
use App\Models\BigData\Dictionaries\CasingType;
use Carbon\Carbon;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\DB;

class DictionaryService
{
    const DICTIONARIES = [
        'well_categories' => [
            'class' => WellCategory::class,
            'name_field' => 'name'
        ],
        'well_types' => [
            'class' => WellType::class,
            'name_field' => 'name'
        ],
        'companies' => [
            'class' => Company::class,
            'name_field' => 'name'
        ],
        [
            'equips' => Equip::class,
            'name_field' => 'name_ru'
        ],
        [
            'casings' => CasingType::class,
            'od' => 'name_ru'
        ],

    ];

    const TREE_DICTIONARIES = [
        'orgs' => [
            'class' => Org::class,
            'name_field' => 'name'
        ]
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
                case 'casing_types':
                    $dict = $this->getCasingTypeDict();
                default:
                    throw new DictionaryNotFound();
            }
        }

        $this->cache->set($cacheKey, $dict, Carbon::now()->addMinutes(self::CACHE_TTL));
        return $dict;
    }

    private function getPlainDict(string $dict): array
    {
        $dictClass = self::DICTIONARIES[$dict]['class'];
        $nameField = self::DICTIONARIES[$dict]['name_field'] ?? 'name';

        return $dictClass::query()
            ->select('id')
            ->selectRaw("$nameField as name")
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
    }

    private function getTreeDict(string $dict): array
    {
        $dictClass = self::TREE_DICTIONARIES[$dict]['class'];
        $nameField = self::TREE_DICTIONARIES[$dict]['name_field'] ?? 'name';

        $items = $dictClass::query()
            ->select('id', 'parent_id')
            ->selectRaw("$nameField as label")
            ->orderBy('parent_id', 'asc')
            ->orderBy($nameField, 'asc')
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
            ->table('tbdi.geo as g')
            ->select('g.id', 'g.name as label', 'gp.id as parent_id')
            ->distinct()
            ->orderBy('parent_id', 'asc')
            ->orderBy('label', 'asc')
            ->leftJoin(
                'tbdi.geo as gp',
                function ($join) {
                    $join->on('gp.id', '=', 'g.parent_id');
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