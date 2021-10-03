<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Infrastructure\History;
use App\Models\BigData\Well;
use App\Services\BigData\FieldLimitsService;
use App\Services\BigData\TableFormHeaderService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class TableForm extends BaseForm
{
    protected $jsonValidationSchemeFileName = 'table_form.json';
    protected $tableHeaderService;

    abstract protected function saveSingleFieldInDB(array $params): void;

    public function __construct(Request $request)
    {
        $this->tableHeaderService = app()->make(TableFormHeaderService::class);
        parent::__construct($request);
    }


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
        $saveParams = [
            'field' => $column['code'],
            'wellId' => $wellId,
            'date' => Carbon::parse($copyRow->dbeg ?? $date)->timezone('Asia/Almaty'),
            'value' => 1,
        ];
        $this->saveSingleFieldInDB($saveParams);
        $saveParams = [
            'field' => $columnTo['code'],
            'wellId' => $wellId,
            'date' => Carbon::parse($date)->timezone('Asia/Almaty'),
            'value' => $copyValue,
        ];
        $this->saveSingleFieldInDB($saveParams);


        return [];
    }

    public function saveSingleField(string $field)
    {
        $this->validateSingleField($field);
        $saveParams = [
            'field' => $field,
            'wellId' => $this->request->get('well_id'),
            'date' => Carbon::parse($this->request->get('date')),
            'value' => $this->request->get($field),
        ];
        $this->saveSingleFieldInDB($saveParams);
        $this->saveHistory($field, $this->request->get($field));

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getFormInfo(): array
    {
        $params = $this->params();
        $params = $this->mapParams($params);

        return [
            'params' => $params,
            'fields' => $this->getFields()->pluck('', 'code')->toArray(),
            'available_actions' => $this->getAvailableActions()
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
            $row = $this->addAdditionalFilters($row, $fieldParams);
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
                case 'prod.bottom_hole':
                    $result[$table] = DB::connection('tbd')
                        ->table('prod.bottom_hole as bh')
                        ->whereIn('bh.well', $wellIds)
                        ->whereDate('data', '<=', $date)
                        ->orderBy('data', 'desc')
                        ->get()
                        ->groupBy('well');

                    break;
                case 'prod.well_geo':
                    $result[$table] = DB::connection('tbd')
                        ->table('prod.well_geo as wg')
                        ->whereIn('wg.well', $wellIds)
                        ->whereDate('dbeg', '<=', $date)
                        ->join('dict.geo as g', 'g.id', 'wg.geo')
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well');

                    break;
                case 'prod.well_constr':
                    $result[$table] = DB::connection('tbd')
                        ->table('prod.well_constr as wc')
                        ->whereIn('wc.well', $wellIds)
                        ->join('dict.tube_nom as tn', 'tn.id', 'wc.casing_nom')
                        ->get()
                        ->groupBy('well');

                    break;
                case 'prod.tech_mode_prod_oil':
                    $result[$table] = DB::connection('tbd')
                        ->table($table)
                        ->whereIn('well', $wellIds)
                        ->whereDate('dbeg', '<=', $date)
                        ->orderBy('dbeg', 'desc')
                        ->limit(20)
                        ->get()
                        ->groupBy('well');
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
        $filter = json_decode($this->request->get('filter'));
        return Carbon::parse($date, 'Asia/Almaty')->diffInDays(
                Carbon::parse($filter->date ?? null, 'Asia/Almaty')
            ) === 0;
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
                    $row[$field['code']]['limits'] = isset($row['id']) ? ($fieldLimits[$row['id']] ?? null) : null;
                }
                return $row;
            }
        );
    }

    protected function mapParams(array $params)
    {
        if (!empty($params['filter'])) {
            $params['filter'] = array_map(
                function ($item) {
                    if ($item['type'] === 'date' && !empty($item['default'])) {
                        $item['default'] = Carbon::createFromTimestamp(strtotime($item['default']))->timezone(
                            'Asia/Almaty'
                        );
                    }
                    return $item;
                },
                $params['filter']
            );
        }

        if (!empty($params['merge_columns'])) {
            $params['complicated_header'] = $this->tableHeaderService->getHeader(
                $params['columns'],
                $params['merge_columns']
            );
        }

        return $params;
    }

    protected function getWells(int $id, string $type, \stdClass $filter, array $params): Collection
    {
        $wellsQuery = Well::query()
            ->with('techs', 'geo')
            ->select('id', 'uwi')
            ->orderBy('uwi')
            ->active(Carbon::parse($filter->date));


        if ($type === 'tech') {
            $tech = Tech::find($id);
            $wellsQuery->whereHas(
                'techs',
                function ($query) use ($tech, $filter) {
                    return $query
                        ->where('dict.tech.id', $tech->id)
                        ->whereDate('dict.tech.dbeg', '<=', $filter->date)
                        ->whereDate('dict.tech.dend', '>=', $filter->date);
                }
            );
        } else {
            $wellsQuery->where('id', $id);
        }

        if (isset($params['filter']['well_category'])) {
            $wellsQuery->whereHas(
                'category',
                function ($query) use ($params) {
                    return $query
                        ->select('dict.well_category_type.id')
                        ->from('dict.well_category_type')
                        ->whereIn('code', $params['filter']['well_category']);
                }
            );
        }

        if (isset($params['filter']['row_id'])) {
            $wellsQuery->where('id', $params['filter']['row_id']);
        }

        return $wellsQuery->get();
    }

    protected function saveHistory(string $field, $value)
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
            $query = $this->addAdditionalFilters($query, $column);
        }

        return $query->first();
    }

    private function addAdditionalFilters($query, array $field)
    {
        if (!empty($field['additional_filter'])) {
            foreach ($field['additional_filter'] as $key => $value) {
                if (is_array($value)) {
                    $entityQuery = DB::connection('tbd')->table($value['table']);
                    foreach ($value['fields'] as $fieldName => $fieldValue) {
                        $entityQuery->where($fieldName, $fieldValue);
                    }
                    $entity = $entityQuery->first();
                    if (!empty($entity)) {
                        $query = $query->where($key, $entity->id);
                    }
                    continue;
                }
                $query = $query->where($key, $value);
            }
        }
        return $query;
    }
}