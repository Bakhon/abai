<?php


namespace App\Services\BigData;


use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StructureService
{

    const FULL_TREE_KEY = 'bd_org_tech_tree_full';

    public function getTreeWithPermissions()
    {
        $userSelectedTreeItems = auth()->user()->org_structure;
        $fullTree = $this->getTree(Carbon::now());
        $tree = [];
        $this->fillTree($fullTree, $tree, $userSelectedTreeItems);
        return $tree;
    }

    public function fillTree($branch, &$tree, $userSelectedTreeItems)
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

    public function getTree(Carbon $date, bool $showWells = false, $isCacheResults = true)
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

    public function getFullTree()
    {
        if (Cache::has(self::FULL_TREE_KEY)) {
            return Cache::get(self::FULL_TREE_KEY);
        }

        return $this->generateFullTree();
    }

    public function generateFullTree()
    {
        $tree = $this->getTree(Carbon::now()->timezone('Asia/Almaty'), true, false);
        Cache::put(self::FULL_TREE_KEY, $tree, now()->addDay());
        return $tree;
    }

    private function getOrgStructure()
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

    private function getTechStructure(Carbon $date, bool $showWells)
    {
        $cacheKey = 'bd_tech_with_wells_' . $date->format('d.m.Y');
        $techData = [];
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $techs = Tech::query()
            ->whereIn('tech_type', [Tech::TYPE_GZU, Tech::TYPE_GU, Tech::TYPE_ZU, Tech::TYPE_AGZU, Tech::TYPE_SPGU])
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

    private function clearTechStructure(array $result, bool $showWells)
    {
        foreach ($result as $key => $tech) {
            if (!empty($tech['children'])) {
                if (!$showWells) {
                    unset($result[$key]['wells']);
                }
                $result[$key]['children'] = $this->clearTechStructure($result[$key]['children'], $showWells);
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
}