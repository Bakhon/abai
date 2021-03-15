<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FluidProduction extends TableForm
{
    protected $configurationFileName = 'fluid_production';

    public function saveSingleField(string $field)
    {
        $this->validateSingleField($field);
        $this->saveSingleFieldInDB($field);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getRows(array $params = [])
    {
        $tech = Tech::find($this->request->get('tech'));

        $wellsQuery = Well::query()
            ->with('techs', 'geo')
            ->select('id', 'uwi')
            ->orderBy('uwi')
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

        $rowData = [];

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        foreach ($tables as $table) {
            switch ($table) {
                case 'tbdi.well_expl':

                    $rowData[$table] = DB::connection('tbd')
                        ->table('tbdi.well_expl as we')
                        ->whereIn('we.well_id', $wells->pluck('id')->toArray())
                        ->whereDate('dbeg', '<=', $this->request->get('date'))
                        ->leftJoin('tbdi.well_expl_type as wet', 'we.well_expl_type_id', '=', 'wet.id')
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well_id');

                    break;
                case 'tbdi.tech_mode_well':

                    $rowData[$table] = DB::connection('tbd')
                        ->table('tbdi.tech_mode as tm')
                        ->whereIn('tm.well_id', $wells->pluck('id')->toArray())
                        ->whereDate('dbeg', '<=', $this->request->get('date'))
                        ->leftJoin('tbdi.tech_mode_well as tmw', 'tmw.tech_mode_id', '=', 'tm.id')
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well_id');

                    break;
                default:
                    $rowData[$table] = DB::connection('tbd')
                        ->table($table)
                        ->whereIn('well_id', $wells->pluck('id')->toArray())
                        ->whereDate('dbeg', '<=', $this->request->get('date'))
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well_id');
            }
        }

        $wells->transform(
            function ($item) use ($rowData) {
                $result = [
                    'uwi' => [
                        'id' => $item->id,
                        'name' => $item->uwi,
                        'href' => '#'
                    ]
                ];

                $measurementFields = $this->getMeasurementsByDates($rowData['tbdic.meas_log_cut'], $item);
                $result = array_merge($result, $measurementFields);

                foreach ($this->getFields() as $field) {
                    if (!empty($field['table'])) {
                        switch ($field['table']) {
                            case 'tbdic.meas_log_cut':
                                continue;
                            default:
                                $result[$field['code']] = $this->getFieldByDates(
                                    $field,
                                    $rowData[$field['table']],
                                    $item
                                );
                        }
                    } else {
                        switch ($field['code']) {
                            case 'geo':

                                $result[$field['code']] = [
                                    'value' => $this->getGeoBreadcrumbs($item->geo->first())
                                ];
                                break;
                        }
                    }
                }

                return $result;
            }
        );

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

    protected function getFilterTree(): array
    {
        $orgData = $this->getOrgWithWells();
        $techData = $this->getTechWithWells();
        return $this->combineOrgWithTechData($orgData, $techData);
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

    private function getMeasurementsByDates(Collection $measurements, Model $item): array
    {
        if (empty($measurements->get($item->id))) {
            return [];
        }

        $result = [];
        $measurementFields = [
            'p_buf',
            'p_zatr',
            'p_buf_b',
            'p_buf_a',
            'gas_factor',
            'note',
            'prod_decline_reason',
        ];


        foreach ($measurements->get($item->id) as $measurement) {
            foreach ($measurementFields as $field) {
                if (isset($result[$field])) {
                    break;
                }
                if (empty($measurement->{$field})) {
                    continue;
                }
                $result[$field] = [
                    'id' => $measurement->id,
                    'value' => $measurement->{$field},
                    'date' => !$this->isCurrentDay($measurement->dbeg) ? $measurement->dbeg : null
                ];
            }
        }

        foreach ($measurementFields as $field) {
            if (!isset($result[$field])) {
                $result[$field] = [
                    'id' => null,
                    'value' => null,
                    'date' => null
                ];
            }
        }

        return $result;
    }

    private function getFieldByDates(array $fieldParams, Collection $collection, Model $item)
    {
        if (is_null($collection->get($item->id))) {
            return [];
        }
        $row = $collection->get($item->id)->first();
        $value = $row->{$fieldParams['column']};

        switch ($fieldParams['type']) {
            case 'float':
                $value = floatval($value);
                break;
            case 'integer':
                $value = intval($value);
                break;
        }

        return [
            'id' => $row->id,
            'value' => $value,
            'date' => !$this->isCurrentDay($row->dbeg) ? $row->dbeg : null
        ];
    }

    private function isCurrentDay(string $date)
    {
        return Carbon::parse($date)->diffInDays(Carbon::parse($this->request->get('date'))) === 0;
    }

    protected function saveSingleFieldInDB(string $field): void
    {
        $column = $this->getFieldByCode($field);

        $item = $this->getFieldRow($column, $this->request->get('well_id'), $this->request->get('date'));

        if (empty($item)) {
            DB::connection('tbd')
                ->table($column['table'])
                ->insert(
                    [
                        'well_id' => $this->request->get('well_id'),
                        $column['column'] => $this->request->get($field),
                        'dbeg' => Carbon::parse($this->request->get('date'))->toDateTimeString(),
                        'dend' => Carbon::parse($this->request->get('date'))->addDay()->toDateTimeString()
                    ]
                );
        } else {
            DB::connection('tbd')
                ->table($column['table'])
                ->where('id', $item->id)
                ->update(
                    [
                        $column['column'] => $this->request->get($field)
                    ]
                );
        }
    }

    private function getFieldRow(array $column, int $wellId, string $date)
    {
        return DB::connection('tbd')
            ->table($column['table'])
            ->where('well_id', $wellId)
            ->whereDate(
                'dbeg',
                '=',
                Carbon::parse($date)->toDateTimeString()
            )
            ->first();
    }

    private function getOrgWithWells()
    {
        $orgData = [];
        if (Cache::has('bd_org_with_wells')) {
            return Cache::get('bd_org_with_wells');
        }

        $orgs = Org::with('wells', 'type')
            ->get();
        foreach ($orgs as $org) {
            $orgData[$org->id] = [
                'id' => $org->id,
                'name' => $org->name,
                'wells' => $org->wells->pluck('id')->toArray(),
                'type' => 'org',
                'parent_id' => $org->parent_id
            ];
        }
        Cache::put('bd_org_with_wells', $orgData, now()->addDay());

        return $orgData;
    }

    private function getTechWithWells()
    {
        $techData = [];
        if (Cache::has('bd_tech_with_wells_' . $this->request->get('date'))) {
            $techData = Cache::get('bd_tech_with_wells_' . $this->request->get('date'));
            return $this->generateTree($techData);
        }

        $techs = Tech::query()
            ->with('wells', 'type')
            ->where('dbeg', '<=', Carbon::parse($this->request->get('date')))
            ->where('dend', '>=', Carbon::parse($this->request->get('date')))
            ->get();
        foreach ($techs as $tech) {
            $techData[$tech->id] = [
                'id' => $tech->id,
                'name' => $tech->name,
                'wells' => $tech->wells->pluck('id')->toArray(),
                'type' => 'tech',
                'parent_id' => $tech->parent_id
            ];
        }

        usort(
            $techData,
            function ($a, $b) {
                return $a['parent_id'] > $b['parent_id'] ? 1 : -1;
            }
        );

        foreach ($techData as $tech) {
            if (!empty($tech['parent_id']) && !empty($techData[$tech['parent_id']])) {
                $techData[$tech['parent_id']]['wells'] = array_unique(
                    array_merge(
                        $techData[$tech['parent_id']]['wells'],
                        $tech['wells']
                    )
                );
            }
        }
        Cache::put('bd_tech_with_wells_' . $this->request->get('date'), $techData, now()->addDay());
        return $this->generateTree($techData);
    }

    private function combineOrgWithTechData($orgData, $techData)
    {
        foreach ($orgData as &$org) {
            if (empty($org['wells'])) {
                continue;
            }

            foreach ($techData as $keyTech => $tech) {
                if (count(array_intersect($org['wells'], $tech['wells'])) > 0) {
                    $org['children'][] = $tech;
                    unset($techData[$keyTech]);
                    break;
                }
            }
        }
        unset($org);

        return $this->generateTree($orgData);
    }
}