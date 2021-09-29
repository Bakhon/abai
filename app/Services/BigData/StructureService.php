<?php


namespace App\Services\BigData;


use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StructureService
{

    const FULL_TREE_KEY = 'bd_org_tech_tree_full';

    private static $childrenIds = [];

    public function getTreeWithPermissions(): array
    {
        $userSelectedTreeItems = auth()->user()->org_structure;
        $fullTree = $this->getTree(Carbon::now());
        $tree = [];
        $this->fillTree($fullTree, $tree, $userSelectedTreeItems);
        return $tree;
    }

    public function getTree(Carbon $date, bool $showWells = false, $isCacheResults = true): array
    {
        if ($isCacheResults) {
            $cacheKey = 'bd_org_tech_' . $date->format('d.m.Y');
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }

        $orgStructures = $this->getOrgStructure();
        $techStructure = $this->getTechStructure($date, $showWells);

        $orgTechs = DB::connection('tbd')
            ->table('prod.org_tech')
            ->select('org', 'tech')
            ->get()
            ->mapToGroups(
                function ($item, $key) {
                    return [
                        $item->org => $item->tech
                    ];
                }
            )
            ->toArray();

        foreach ($orgStructures as &$org) {
            foreach ($techStructure as $tech) {
                if (isset($orgTechs[$org['id']]) && in_array($tech['id'], $orgTechs[$org['id']])) {
                    $org['children'][] = $tech;
                }
            }
        }
        unset($org);

        $result = $this->generateTree($orgStructures);

        if ($isCacheResults) {
            Cache::put($cacheKey, $result, now()->addDay());
        }

        return $result;
    }

    private function getOrgStructure(): array
    {
        $orgData = [];
        if (Cache::has('bd_org_with_wells')) {
            return Cache::get('bd_org_with_wells');
        }

        $orgs = Org::query()
            ->with('type')
            ->get();

        foreach ($orgs as $org) {
            $orgData[$org->id] = [
                'id' => $org->id,
                'name' => $org->name_ru,
                'type' => 'org',
                'sub_type' => $org->type->code,
                'parent_id' => $org->parent
            ];
        }

        usort(
            $orgData,
            function ($a, $b) {
                return strnatcasecmp($a['name'], $b['name']);
            }
        );

        Cache::put('bd_org_with_wells', $orgData, now()->addDay());

        return $orgData;
    }

    private function getTechStructure(Carbon $date, bool $showWells): array
    {
        $cacheKey = 'bd_tech_with_wells_' . $date->format('d.m.Y');
        $techData = [];
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $techs = Tech::query()
            ->whereIn(
                'tech_type',
                function ($query) {
                    return $query
                        ->from('dict.tech_type')
                        ->select('id')
                        ->whereIn(
                            'code',
                            [
                                Tech::TYPE_GZU,
                                Tech::TYPE_GU,
                                Tech::TYPE_ZU,
                                Tech::TYPE_AGZU,
                                Tech::TYPE_SPGU,
                                Tech::TYPE_KNS,
                                Tech::TYPE_BKNS,
                                Tech::TYPE_OPPS
                            ]
                        );
                }
            )
            ->where('dbeg', '<=', $date)
            ->where('dend', '>=', $date)
            ->with(
                [
                    'type',
                    'wells' =>
                        function ($query) use ($date) {
                            $query->active($date);
                        }
                ]
            )
            ->get();

        $techIds = $techs->pluck('id')->toArray();

        foreach ($techs as $tech) {
            $techData[$tech->id] = [
                'id' => $tech->id,
                'name' => $tech->name_ru,
                'type' => 'tech',
                'sub_type' => $tech->type->code,
                'wells' => $tech->wells->pluck('id')->toArray(),
                'parent_id' => in_array($tech->parent, $techIds) ? $tech->parent : null
            ];
        }

        uasort(
            $techData,
            function ($a, $b) {
                return strnatcasecmp($a['name'], $b['name']);
            }
        );

        $result = $this->generateTree($techData);
        $result = $this->clearTechStructure($result, $showWells);

        Cache::put($cacheKey, $result, now()->addDay());
        return $result;
    }

    public function fillTree($branch, &$tree, $userSelectedTreeItems): void
    {
        foreach ($branch as $item) {
            $key = implode(':', [$item['type'], $item['id']]);
            if (in_array($key, $userSelectedTreeItems)) {
                $tree[] = $item;
                continue;
            }
            if (!empty($item['children'])) {
                $this->fillTree($item['children'], $tree, $userSelectedTreeItems);
            }
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

    private function createTree(&$list, $parent): array
    {
        $tree = array();
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                if (!empty($l['children'])) {
                    $l['children'] = array_merge($this->createTree($list, $list[$l['id']]), $l['children']);
                } else {
                    $l['children'] = $this->createTree($list, $list[$l['id']]);
                }
            }
            $tree[] = $l;
        }
        return $tree;
    }

    private function clearTechStructure(array $result, bool $showWells): array
    {
        foreach ($result as $key => $tech) {
            if (!empty($tech['children'])) {
                if (!$showWells) {
                    unset($result[$key]['wells']);
                }
                $result[$key]['children'] = array_values(
                    $this->clearTechStructure($result[$key]['children'], $showWells)
                );
                continue;
            }

            if (empty($tech['wells'])) {
                unset($result[$key]);
                continue;
            }

            if (!$showWells) {
                unset($result[$key]['wells']);
            }
        }
        return $result;
    }

    public function getFlattenTreeWithPermissions(): array
    {
        $tree = $this->getTreeWithPermissions();
        return $this->getFlatten($tree);
    }

    private function getFlatten(array $tree, array $parent = null)
    {
        $result = [];
        foreach ($tree as $item) {
            if ($parent) {
                $item['parent_id'] = $parent['id'];
                $item['parent_type'] = $parent['type'];
            }
            if (isset($item['children'])) {
                $result = array_merge($result, $this->getFlatten($item['children'], $item));
                unset($item['children']);
            }
            $result[] = $item;
        }
        return $result;
    }

    public function getFullTree(): array
    {
        if (Cache::has(self::FULL_TREE_KEY)) {
            return Cache::get(self::FULL_TREE_KEY);
        }

        return $this->generateFullTree();
    }

    public function getFlattenTree(): array
    {
        $tree = $this->getFullTree();
        return $this->getFlatten($tree);
    }

    public function generateFullTree(): array
    {
        $tree = $this->getTree(Carbon::now()->timezone('Asia/Almaty'), true, false);
        Cache::put(self::FULL_TREE_KEY, $tree, now()->addDay());
        return $tree;
    }

    public static function getChildIds(array $orgs, int $selectedUserDzo): array
    {
        self::$childrenIds[] = $selectedUserDzo;
        foreach ($orgs as $child) {
            self::getChildsRecursive($child);
        }

        return self::$childrenIds;
    }

    private static function getChildsRecursive(array $child): void
    {
        if (!isset($child['children'])) {
            return;
        }
        if (in_array($child['id'], self::$childrenIds)) {
            self::$childrenIds = array_merge(
                self::$childrenIds,
                array_map(function ($item) {
                    return $item['id'];
                }, $child['children'])
            );
        }
        foreach ($child['children'] as $childrenItem) {
            self::getChildsRecursive($childrenItem);
        }
    }

    public function getPath(int $id, string $type): ?Collection
    {
        $tree = collect($this->getFlattenTree());
        $item = $tree->where('id', $id)->where('type', $type)->first();
        if (empty($item)) {
            return null;
        }

        $path = [$item];
        while ($item['parent_id'] !== null) {
            $parent = $tree->where('id', $item['parent_id'])->where('type', $item['parent_type'])->first();
            $path[] = $parent;
            $item = $parent;
        }

        return collect(array_reverse($path));
    }
}