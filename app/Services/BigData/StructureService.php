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
    const TYPE_HIERARCHY = [
        'geo' => [
            [
                'name' => 'FLD',
                'children' => [
                    [
                        'name' => 'GBLK',
                        'children' => [
                            [
                                'name' => 'HRZ'
                            ]
                        ]
                    ]
                ]
            ],
        ],
        'tech' => [
            [
                'name' => 'GPST',
                'children' => [
                    [
                        'name' => 'WDM'
                    ]
                ]
            ],
            [
                'name' => 'OPPS',
                'children' => [
                    [
                        'name' => 'WIDM'
                    ],
                    [
                        'name' => 'WDM'
                    ],
                    [
                        'name' => 'GMS'
                    ]
                ]
            ],
            [
                'name' => 'OTU',
                'children' => [
                    [
                        'name' => 'GMS'
                    ]
                ]
            ],
            [
                'name' => 'GU',
                'children' => [
                    [
                        'name' => 'MS'
                    ]
                ]
            ]
        ],
        'org' => [
            [
                'name' => 'SUBC',
                'children' => [
                    [
                        'name' => 'FOFS',
                        'children' => [
                            [
                                'name' => 'WKRP',
                            ],
                            [
                                'name' => 'SSFP',
                            ],
                            [
                                'name' => 'OGPU',
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    const FULL_TREE_KEY = 'bd_org_tech_tree_full';

    private static $childrenIds = [];

    public function getFormTree(array $types): array
    {
        if ($this->hasType('geo', $types)) {
            $geoStructureService = app()->make(GeoStructureService::class);
            return $geoStructureService->getGeoTreeWithPermissions($types);
        }

        return $this->getTreeWithPermissions($types);
    }

    public function getTreeWithPermissions(array $types = []): array
    {
        $userSelectedTreeItems = auth()->user()->org_structure;
        $fullTree = $this->getTree(Carbon::now(), false, false, $types);
        $tree = [];
        $this->generateTreeWithPermissions($fullTree, $tree, $userSelectedTreeItems);
        return $this->fillTreeWithFullNames($tree);
    }

    public function getTree(
        Carbon $date,
        bool $showWells = false,
        $isCacheResults = true,
        array $types = []
    ): array {
        if ($isCacheResults) {
            $cacheKey = 'bd_org_tech_' . $date->format('d.m.Y');
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
        }

        $orgStructures = $this->getOrgStructure($types);
        if ($this->hasType('tech', $types) || in_array('well', $types)) {
            $techStructure = $this->getTechStructure($date, $showWells, $types);

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
        }

        $result = $this->generateTree($orgStructures);

        if ($isCacheResults) {
            Cache::put($cacheKey, $result, now()->addDay());
        }

        return $result;
    }

    private function getOrgStructure(array $types = []): array
    {
        $orgData = [];
        $cacheKey = 'bd_org_with_wells_' . implode('_', $types);
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $orgQuery = Org::query()
            ->with('type');
        if (!empty($types) && $this->getSubTypes('org', $types)) {
            $orgQuery->whereHas('type', function ($query) use ($types) {
                $query->whereIn('code', $this->getSubTypes('org', $types));
            });
        }

        $orgs = $orgQuery->get();

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

        Cache::put($cacheKey, $orgData, now()->addDay());

        return $orgData;
    }

    private function getTechStructure(Carbon $date, bool $showWells, array $types = []): array
    {
        $defaultTechTypes = [
            Tech::TYPE_GZU,
            Tech::TYPE_GU,
            Tech::TYPE_ZU,
            Tech::TYPE_AGZU,
            Tech::TYPE_SPGU,
            Tech::TYPE_KNS,
            Tech::TYPE_BKNS,
            Tech::TYPE_OPPS,
            Tech::TYPE_OTU,
            Tech::TYPE_WIDM,
            Tech::TYPE_WDM,
        ];

        $subTypes = $this->getSubTypes('tech', $types);
        $types = !empty($subTypes) ? $subTypes : $defaultTechTypes;

        $cacheKey = 'bd_tech_with_wells_' . $date->format('d.m.Y') . '_' . implode('_', $types);
        $techData = [];
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $techs = Tech::query()
            ->whereIn(
                'tech_type',
                function ($query) use ($types) {
                    return $query
                        ->from('dict.tech_type')
                        ->select('id')
                        ->whereIn(
                            'code',
                            $types
                        );
                }
            )
            ->where('dbeg', '<=', $date)
            ->where('dend', '>=', $date)
            ->with(
                [
                    'type',
                    'wells'
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

    public function generateTreeWithPermissions($branch, &$tree, $userSelectedTreeItems): void
    {
        foreach ($branch as $item) {
            $key = implode(':', [$item['type'], $item['id']]);
            if (!empty($userSelectedTreeItems) && in_array($key, $userSelectedTreeItems)) {
                $tree[] = $item;
                continue;
            }
            if (!empty($item['children'])) {
                $this->generateTreeWithPermissions($item['children'], $tree, $userSelectedTreeItems);
            }
        }
    }

    protected function fillTreeWithFullNames($tree): array
    {
        foreach ($tree as $key => $item) {
            $tree[$key] = $this->addFullNameToTreeItem($item);
        }
        return $tree;
    }

    private function addFullNameToTreeItem($item, $parentName = null): array
    {
        $item['full_name'] = $parentName ? $parentName . ' / ' . $item['name'] : $item['name'];
        if (empty($item['children'])) {
            return $item;
        }

        foreach ($item['children'] as $key => $child) {
            $item['children'][$key] = $this->addFullNameToTreeItem($child, $item['full_name']);
        }
        return $item;
    }

    protected function generateTree($items): array
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

    private function hasType(string $mainType, array $types)
    {
        foreach ($types as $type) {
            if (strpos($type, $mainType) === 0) {
                return true;
            }
        }
        return false;
    }

    protected function getSubTypes(string $mainType, array $types)
    {
        $subTypes = array_filter(
            array_map(function ($type) use ($mainType) {
                if (strpos($type, ':') === false) {
                    return null;
                }
                list($type, $subType) = explode(':', $type);
                if ($type !== $mainType) {
                    return null;
                }
                return strtoupper($subType);
            }, $types)
        );

        $result = [];
        foreach (self::TYPE_HIERARCHY[$mainType] as $key => $subType) {
            $ancestors = [];
            $this->findTypeWithAncestors($subType, $subTypes, $ancestors, $result);
        }

        return array_unique($result);
    }

    protected function findTypeWithAncestors($subType, $subTypes, $ancestors, &$result)
    {
        $ancestors[] = $subType['name'];
        if (!empty($subType['children'])) {
            foreach ($subType['children'] as $child) {
                $this->findTypeWithAncestors($child, $subTypes, $ancestors, $result);
            }
        }
        if (in_array($subType['name'], $subTypes)) {
            $result = array_merge($result, $ancestors);
        }
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

    public function getFlattenTree(): Collection
    {
        $tree = $this->getFullTree();
        return collect($this->getFlatten($tree));
    }

    public function generateFullTree(): array
    {
        $tree = $this->getTree(Carbon::now()->timezone('Asia/Almaty'), true, false);
        Cache::put(self::FULL_TREE_KEY, $tree, now()->addDay());
        return $tree;
    }

    public static function getChildIds(array $orgs, int $parentId): array
    {
        self::$childrenIds[] = $parentId;
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
        $tree = $this->getFlattenTree();
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

    public function getOrgIds(int $orgId)
    {
        $orgStructure = $this->getFlattenTreeWithPermissions();
        $org = array_filter($orgStructure, function ($item) use ($orgId) {
            return $item['type'] === 'org' && $item['id'] === $orgId;
        });
        $org = reset($org);
        return $this->getOrgWithChildren($orgStructure, $org['id']);
    }

    private function getOrgWithChildren(array $orgStructure, $orgId)
    {
        $ids = [$orgId];
        $children = array_filter($orgStructure, function ($item) use ($orgId) {
            return $item['type'] === 'org' && $item['parent_id'] === $orgId;
        });
        foreach ($children as $child) {
            $ids = array_merge($ids, $this->getOrgWithChildren($orgStructure, $child['id']));
        }
        return $ids;
    }


    public function getTechIds(int $parentId, string $parentType)
    {
        $structureService = app()->make(StructureService::class);
        $orgStructure = $structureService->getFlattenTreeWithPermissions();
        $org = array_filter($orgStructure, function ($item) use ($parentId, $parentType) {
            return $item['type'] === $parentType && $item['id'] === $parentId;
        });
        $org = reset($org);
        return $this->getTechWithChildren($orgStructure, $org);
    }

    private function getTechWithChildren(array $orgStructure, $parent)
    {
        $ids = [];
        if ($parent['type'] === 'tech') {
            $ids[] = $parent['id'];
        }

        $children = array_filter($orgStructure, function ($item) use ($parent) {
            return isset($item['parent_type']) && $item['parent_type'] === $parent['type'] && $item['parent_id'] === $parent['id'];
        });
        foreach ($children as $child) {
            $ids = array_merge($ids, $this->getTechWithChildren($orgStructure, $child));
        }
        return $ids;
    }
}