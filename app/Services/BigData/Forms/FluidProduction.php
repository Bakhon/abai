<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FluidProduction extends TableForm
{

    protected $configurationFileName = 'fluid_production';

    public function getRows(array $params = [])
    {
        $tech = Tech::find($this->request->get('tech'));

        $wellsQuery = Well::query()
            ->with('techs', 'geo')
            ->select('id', 'uwi')
            ->orderBy('uwi')
            ->active(Carbon::parse($this->request->get('date')))
            ->whereHas(
                'techs',
                function ($query) use ($tech) {
                    return $query
                        ->where('tbdi.tech.id', $tech->id)
                        ->whereDate('tbdi.tech.dbeg', '<=', $this->request->get('date'))
                        ->whereDate('tbdi.tech.dend', '>=', $this->request->get('date'));
                }
            );

        if (isset($params['filter']['row_id'])) {
            $wellsQuery->where('id', $params['filter']['row_id']);
        }

        $wells = $wellsQuery->get();

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($this->request->get('date'))
        );

        $wells->transform(
            function ($item) use ($rowData) {
                $result = [];

                foreach ($this->getFields() as $field) {
                    $fieldValue = $this->getFieldValue($field, $rowData, $item);
                    if (!empty($fieldValue)) {
                        $result[$field['code']] = $fieldValue;
                    }
                }
                return $result;
            }
        );

        $this->addLimits($wells);

        return $wells->toArray();
    }

    public function getGeoBreadcrumbs($geo)
    {
        if (Cache::has('bd_geo_breadcrumb_' . $geo->id)) {
            return Cache::get('bd_geo_breadcrumb_' . $geo->id);
        }

        $ancestors = $geo->ancestors()
            ->reverse()
            ->pluck('name')
            ->toArray();

        $ancestors[] = $geo->name;
        $breadcrumbs = implode(' / ', $ancestors);
        Cache::put('bd_geo_breadcrumb_' . $geo->id, $breadcrumbs, now()->addMonth());

        return $breadcrumbs;
    }

    public function getFilterTree(): array
    {
        return $this->combineOrgWithTechData();
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

    protected function getFormatedFieldValue(array $field, array $rawValue): ?array
    {
        switch ($field['code']) {
            case 'worktime':

                $value = 0;
                if (isset($rawValue['value']) && $rawValue['value'] !== null) {
                    $value = in_array($rawValue['value'], Well::WELL_ACTIVE_STATUSES) ? 1 : 0;
                }

                return [
                    'value' => $value
                ];
        }

        return $rawValue;
    }

    protected function getCustomFieldValue(array $field, array $rowData, Model $item): ?array
    {
        switch ($field['code']) {
            case 'density_oil':

                return [
                    'value' => floatval($item->geo->first()->density_oil)
                ];

            case 'other_uwi':

                return $this->getOtherUwis($item);

            case 'geo':

                return [
                    'value' => $this->getGeoBreadcrumbs($item->geo->first())
                ];
        }

        return null;
    }


    private function getMeasurementFieldByDates(array $fieldParams, Collection $collection, Model $item)
    {
        if (is_null($collection->get($item->id))) {
            return [
                'value' => null
            ];
        }

        foreach ($collection->get($item->id) as $measurement) {
            if (empty($measurement->{$fieldParams['column']})) {
                continue;
            }
            $result = [
                'id' => $measurement->id,
                'value' => null
            ];
            if ($this->isCurrentDay($measurement->dbeg)) {
                $result['value'] = $measurement->{$fieldParams['column']};
            } else {
                $result['old_value'] = $measurement->{$fieldParams['column']};
                $result['date'] = $measurement->dbeg;
            }
            return $result;
        }

        return ['value' => null];
    }

    protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void
    {
        $column = $this->getFieldByCode($field);

        $item = $this->getFieldRow($column, $wellId, $date);

        if (empty($item)) {
            $data = [
                'well_id' => $wellId,
                $column['column'] => $value,
                'dbeg' => $date->toDateTimeString()
            ];

            if (!empty($column['additional_filter'])) {
                foreach ($column['additional_filter'] as $key => $val) {
                    $data[$key] = $val;
                }
            }

            DB::connection('tbd')
                ->table($column['table'])
                ->insert($data);
        } else {
            DB::connection('tbd')
                ->table($column['table'])
                ->where('id', $item->id)
                ->update(
                    [
                        $column['column'] => $value
                    ]
                );
        }
    }

    private function getFieldRow(array $column, int $wellId, Carbon $date)
    {
        $query = DB::connection('tbd')
            ->table($column['table'])
            ->where('well_id', $wellId)
            ->whereBetween(
                'dbeg',
                [
                    (clone $date)->startOfDay(),
                    (clone $date)->endOfDay()
                ]
            );

        if (!empty($column['additional_filter'])) {
            foreach ($column['additional_filter'] as $key => $value) {
                $query->where($key, '=', $value);
            }
        }

        return $query->first();
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
                'name' => $org->name,
                'type' => 'org',
                'parent_id' => $org->parent_id
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

    private function getTechStructure()
    {
        $cacheKey = 'bd_tech_with_wells_' . $this->request->get('date');
        $techData = [];
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $techs = Tech::query()
            ->whereIn('tech_id', [Tech::TYPE_GZU, Tech::TYPE_GU, Tech::TYPE_ZU])
            ->where('dbeg', '<=', Carbon::parse($this->request->get('date')))
            ->where('dend', '>=', Carbon::parse($this->request->get('date')))
            ->get();

        $techIds = $techs->pluck('id')->toArray();

        foreach ($techs as $tech) {
            $techData[$tech->id] = [
                'id' => $tech->id,
                'name' => $tech->name,
                'type' => 'tech',
                'parent_id' => in_array($tech->parent_id, $techIds) ? $tech->parent_id : null
            ];
        }

        uasort(
            $techData,
            function ($a, $b) {
                return strnatcasecmp($a['name'], $b['name']);
            }
        );

        $result = $this->generateTree($techData);
        Cache::put($cacheKey, $result, now()->addDay());
        return $result;
    }

    private function combineOrgWithTechData()
    {
        $cacheKey = 'bd_org_tech_' . $this->request->get('date');
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $orgStructures = $this->getOrgStructure();
        $techStructure = $this->getTechStructure();

        $orgTechs = DB::connection('tbd')
            ->table('dict.org_tech')
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
                    unset($techStructure[$keyTech]);
                }
            }
        }
        unset($org);

        $result = $this->generateTree($orgStructures);
        Cache::put($cacheKey, $result, now()->addDay());

        return $result;
    }

    private function getOtherUwis($item)
    {
        $uwi = DB::connection('tbd')
            ->table('tbdi.well as w')
            ->selectRaw('w.id,w.uwi,array_agg(b.uwi) as other_uwi')
            ->leftJoin('tbdic.joint_wells as j', 'w.id', '=', DB::raw("any(j.well_id_arr)"))
            ->leftJoin('tbdi.well as b', 'b.id', '=', DB::raw('any(array_remove(j.well_id_arr, w.id))'))
            ->where('w.id', $item->id)
            ->groupBy('w.id', 'w.uwi')
            ->first();

        return [
            'value' => $uwi->other_uwi === '{NULL}' ? null : str_replace(['{', '}'], '', $uwi->other_uwi),
        ];
    }
}