<?php


namespace App\Services\BigData;


use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StructureService
{
    public function getTree($date)
    {
        $cacheKey = 'bd_org_tech_' . $date;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $orgStructures = $this->getOrgStructure();
        $techStructure = $this->getTechStructure($date);

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
            foreach ($techStructure as $keyTech => $tech) {
                if (isset($orgTechs[$org['id']]) && in_array($tech['id'], $orgTechs[$org['id']])) {
                    $org['children'][] = $tech;
                }
            }
        }
        unset($org);

        $result = $this->generateTree($orgStructures);
        Cache::put($cacheKey, $result, now()->addDay());

        return $result;
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

    private function getTechStructure($date)
    {
        $cacheKey = 'bd_tech_with_wells_' . $date;
        $techData = [];
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $techs = Tech::query()
            ->whereIn('tech_type', [Tech::TYPE_GZU, Tech::TYPE_GU, Tech::TYPE_ZU, Tech::TYPE_AGZU, Tech::TYPE_SPGU])
            ->where('dbeg', '<=', Carbon::parse($date))
            ->where('dend', '>=', Carbon::parse($date))
            ->with(
                [
                    'wells' =>
                        function ($query) use ($date) {
                            $query->active(Carbon::parse($date));
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
        $result = $this->clearTechStructure($result);

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

    private function clearTechStructure(array $result)
    {
        foreach ($result as $key => $tech) {
            if (!empty($tech['children'])) {
                unset($result[$key]['wells']);
                $result[$key]['children'] = $this->clearTechStructure($result[$key]['children']);
                continue;
            }

            if (empty($tech['wells'])) {
                unset($result[$key]);
                continue;
            }

            unset($result[$key]['wells']);
        }
        return $result;
    }
}