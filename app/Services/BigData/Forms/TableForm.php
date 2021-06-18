<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Infrastructure\History;
use App\Models\Refs\Org;
use App\Services\BigData\FieldLimitsService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class TableForm extends BaseForm
{
    protected $jsonValidationSchemeFileName = 'table_form.json';

    abstract public function getRows(array $params = []);

    abstract protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void;

    public static function getLimitsCacheKey(array $field, CarbonImmutable $yesterday)
    {
        $cacheKey = 'bd_form_limits_' . $yesterday->format('Y-m-d') . '_' . $field['table'] . '_' . $field['column'];
        if (!empty($field['additional_filter'])) {
            $cacheKey .= '_' . base64_encode(json_encode($field['additional_filter']));
        }
        return $cacheKey;
    }


    public function copyFieldValue(int $wellId, Carbon $date)
    {
        $column = $this->getFieldByCode($this->request->get('column'));
        $columnFrom = $this->getFieldByCode($column['copy']['from']);
        $columnTo = $this->getFieldByCode($column['copy']['to']);

        $tables = $this
            ->getFields()
            ->where('code', $columnFrom['code'])
            ->pluck('table')
            ->filter();

        $rowData = $this->fetchRowData($tables, (array)$wellId, $date);

        $copyRow = $rowData[$columnFrom['table']]->get($wellId)->first();
        $copyValue = $copyRow->{$columnFrom['column']};
        $this->saveSingleFieldInDB(
            $column['code'],
            $wellId,
            Carbon::parse($copyRow->dbeg ?? $date)->timezone('Asia/Almaty'),
            1
        );
        $this->saveSingleFieldInDB(
            $columnTo['code'],
            $wellId,
            Carbon::parse($date)->timezone('Asia/Almaty'),
            $copyValue
        );


        return [];
    }

    public function saveSingleField(string $field)
    {
        $this->validateSingleField($field);
        $this->saveSingleFieldInDB(
            $field,
            $this->request->get('well_id'),
            Carbon::parse($this->request->get('date')),
            $this->request->get($field)
        );
        $this->saveHistory($field, $this->request->get($field));

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getFormatedParams(): array
    {
        return [
            'params' => $this->params(),
            'fields' => $this->getFields()->pluck('', 'code')->toArray(),
            'filterTree' => $this->getFilterTree()
        ];
    }

    public function getFields(): Collection
    {
        return collect($this->params()['columns']);
    }

    public function getFieldByCode(string $code)
    {
        return $this->getFields()->where('code', $code)->first();
    }

    protected function getFieldValue(array $field, array $rowData, Model $item): ?array
    {
        $result = $this->getCustomFieldValue($field, $rowData, $item);
        if (is_null($result)) {
            if ($field['type'] === 'link') {
                $result = [
                    'id' => $item->id,
                    'name' => $item->uwi,
                    'href' => '#'
                ];
            } elseif (isset($field['table'])) {
                $result = $this->getFieldByDates(
                    $field,
                    $rowData[$field['table']],
                    $item
                );
            } else {
                $result = [
                    'value' => null
                ];
            }
        }

        return $this->getFormatedFieldValue($field, $result);
    }

    public function getFormatedFieldValue(array $field, array $value): ?array
    {
        return $value;
    }

    protected function getCustomFieldValue(array $field, array $rowData, Model $item): ?array
    {
        return null;
    }

    protected function getFieldByDates(array $fieldParams, Collection $collection, Model $item)
    {
        if (is_null($collection->get($item->id))) {
            return [
                'value' => null
            ];
        }

        $row = $collection->get($item->id);
        if (!empty($fieldParams['additional_filter'])) {
            foreach ($fieldParams['additional_filter'] as $key => $value) {
                $row = $row->where($key, '=', $value);
            }
        }
        $row = $row->first();

        if (empty($row) || !isset($row->{$fieldParams['column']})) {
            return [
                'value' => null
            ];
        }

        $value = $row->{$fieldParams['column']};

        switch ($fieldParams['type']) {
            case 'float':
                $value = floatval($value);
                break;
            case 'integer':
                $value = intval($value);
                break;
        }

        $result = [
            'id' => $row->id,
            'value' => null,
        ];

        $dateField = $fieldParams['date_field'] ?? 'dbeg';
        if ($this->isCurrentDay($row->{$dateField})) {
            $result['value'] = $value;
        } else {
            $result['old_value'] = $value;
            $result['date'] = $row->{$dateField};
        }

        return $result;
    }

    public function fetchRowData(Collection $tables, array $wellIds, Carbon $date, Carbon $dateFrom = null): array
    {
        if (is_null($dateFrom)) {
            $dateFrom = (clone $date)->subMonthNoOverflow();
        }

        $result = [];
        foreach ($tables as $table) {
            switch ($table) {
                case 'tbdi.well_expl':
                    $result[$table] = DB::connection('tbd')
                        ->table('tbdi.well_expl as we')
                        ->whereIn('we.well_id', $wellIds)
                        ->whereDate('dbeg', '<=', $date)
                        ->whereDate('dbeg', '>=', $dateFrom)
                        ->leftJoin('tbdi.well_expl_type as wet', 'we.well_expl_type_id', '=', 'wet.id')
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well_id');

                    break;
                case 'prod.lab_research_value':
                    $result[$table] = DB::connection('tbd')
                        ->table('prod.lab_research as lr')
                        ->whereIn('lr.well', $wellIds)
                        ->whereDate('research_date', '<=', $date)
                        ->whereDate('research_date', '>=', $dateFrom)
                        ->leftJoin('prod.lab_research_value as lrv', 'lrv.research', '=', 'lr.id')
                        ->orderBy('research_date', 'desc')
                        ->get()
                        ->groupBy('well');

                    break;
                case 'prod.gdis_current_value':
                    $result[$table] = DB::connection('tbd')
                        ->table('prod.gdis_current as gc')
                        ->whereIn('gc.well', $wellIds)
                        ->whereDate('meas_date', '<=', $date)
                        ->whereDate('meas_date', '>=', $dateFrom)
                        ->leftJoin('prod.gdis_current_value as gcv', 'gcv.gdis_curr', '=', 'gc.id')
                        ->orderBy('meas_date', 'desc')
                        ->get()
                        ->groupBy('well');

                    break;
                case 'prod.well_status':
                    $result[$table] = DB::connection('tbd')
                        ->table('prod.well_status as ws')
                        ->whereIn('ws.well', $wellIds)
                        ->whereDate('dbeg', '<=', $date)
                        ->whereDate('dbeg', '>=', $dateFrom)
                        ->leftJoin('dict.well_status_type as wst', 'ws.status', '=', 'wst.id')
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well_id');

                    break;
                default:
                    $result[$table] = DB::connection('tbd')
                        ->table($table)
                        ->whereIn('well', $wellIds)
                        ->whereDate('dbeg', '<=', $date)
                        ->whereDate('dbeg', '>=', $dateFrom)
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well');
            }
        }
        return $result;
    }

    protected function isCurrentDay(string $date)
    {
        return Carbon::parse($date)->diffInDays(Carbon::parse($this->request->get('date'))) === 0;
    }

    protected function addLimits(Collection $rows): void
    {
        $rows->transform(
            function ($row) {
                foreach ($this->getFields() as $field) {
                    if (!isset($field['validate_deviation']) || !$field['validate_deviation']) {
                        continue;
                    }
                    if (!$field['is_editable']) {
                        continue;
                    }

                    $cacheKey = self::getLimitsCacheKey($field, CarbonImmutable::yesterday());
                    if (Cache::has($cacheKey)) {
                        $fieldLimits = json_decode(Cache::get($cacheKey), true);
                    } else {
                        $fieldLimits = app()->make(FieldLimitsService::class)->calculateFieldLimits(
                            CarbonImmutable::yesterday(),
                            $field
                        );
                    }
                    $row[$field['code']]['limits'] = $fieldLimits[$row['uwi']['id']] ?? null;
                }
                return $row;
            }
        );
    }

    protected function getFilterTree(): array
    {
        return $this->combineOrgWithTechData();
    }

    private function saveHistory(string $field, $value)
    {
        History::create(
            [
                'form_name' => $this->configurationFileName,
                'payload' => [
                    $field => $value
                ],
                'date' => Carbon::parse($this->request->get('date')),
                'row_id' => $this->request->get('well_id'),
                'user_id' => auth()->id()
            ]
        );
    }

    protected function getFieldRow(array $column, int $wellId, Carbon $date)
    {
        $query = DB::connection('tbd')
            ->table($column['table'])
            ->where('well', $wellId)
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

    private function getTechStructure()
    {
        $cacheKey = 'bd_tech_with_wells_' . $this->request->get('date');
        $techData = [];
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $techs = Tech::query()
            ->whereIn('tech_type', [Tech::TYPE_GZU, Tech::TYPE_GU, Tech::TYPE_ZU, Tech::TYPE_AGZU, Tech::TYPE_SPGU])
            ->where('dbeg', '<=', Carbon::parse($this->request->get('date')))
            ->where('dend', '>=', Carbon::parse($this->request->get('date')))
            ->with(
                [
                    'wells' =>
                        function ($query) {
                            $query->active(Carbon::parse($this->request->get('date')));
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

    protected function combineOrgWithTechData()
    {
        $cacheKey = 'bd_org_tech_' . $this->request->get('date');
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $orgStructures = $this->getOrgStructure();
        $techStructure = $this->getTechStructure();

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