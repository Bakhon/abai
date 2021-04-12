<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Infrastructure\History;
use App\Models\BigData\Well;
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

    public function getRowHistory(Carbon $dateTo, Carbon $dateFrom = null)
    {
        if (is_null($dateFrom)) {
            $dateFrom = (clone $dateTo)->subMonthNoOverflow();
        }

        $wellId = $this->request->get('well_id');
        $well = Well::find($wellId);
        $columnCodes = $this->getRowHistoryColumnCodes($this->request->get('column'));

        $tables = $this
            ->getFields()
            ->whereIn('code', $columnCodes)
            ->pluck('table')
            ->filter()
            ->unique();

        $rowData = $this->fetchRowData($tables, (array)$well->id, $dateTo, $dateFrom);

        $result = [];
        foreach ($this->getFields()->whereIn('code', $columnCodes) as $field) {
            if (empty($field['table'])) {
                $result[$field['code']] = [];
                continue;
            }

            $result[$field['code']] = array_map(
                function ($item) use ($field) {
                    return $this->getFormatedFieldValue($field, $item);
                },
                $this->getFieldHistory(
                    $field,
                    $rowData[$field['table']],
                    $well
                )
            );
        }

        return $this->groupFieldsByDates($result, $dateFrom, $dateTo);
    }

    public function getRowHistoryGraph(Carbon $dateTo, Carbon $dateFrom = null)
    {
        $wellId = $this->request->get('well_id');
        $well = Well::find($wellId);

        $graphColumnCodes = $this->getRowHistoryColumnCodes($this->request->get('column'), 'graph_fields');
        $tables = $this
            ->getFields()
            ->whereIn('code', $graphColumnCodes)
            ->pluck('table')
            ->filter()
            ->unique();

        $rowData = $this->fetchRowData($tables, (array)$well->id, $dateTo, (clone $dateTo)->subYears(10));

        $result = [];
        foreach ($this->getFields()->whereIn('code', $graphColumnCodes) as $field) {
            if (empty($field['table'])) {
                $result[$field['code']] = [];
                continue;
            }

            $result[$field['code']] = array_map(
                function ($item) use ($field) {
                    return $this->getFormatedFieldValue($field, $item);
                },
                $this->getFieldHistory(
                    $field,
                    $rowData[$field['table']],
                    $well
                )
            );
        }

        $minDate = Carbon::now();
        foreach ($rowData as $data) {
            $date = Carbon::parse($data->get($well->id)->sortBy('dbeg')->first()->dbeg);
            $minDate = $date < $minDate ? $date : $minDate;
        }

        return [
            'selectedColumn' => $this->request->get('column'),
            'table' => [
                'rows' => $this->getRowHistory($dateTo, $dateFrom),
                'columns' => $this->getRowHistoryColumnCodes($this->request->get('column'))
            ],
            'graph' => [
                'rows' => $this->groupFieldsByDates($result, $minDate, $dateTo),
                'columns' => $this->getFieldByCode($this->request->get('column'))['graph_fields']
            ]
        ];
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

        $copyValue = $rowData[$columnFrom['table']]->get($wellId)->first()->{$columnFrom['column']};
        $this->saveSingleFieldInDB($column['code'], $wellId, Carbon::parse($date), 1);
        $this->saveSingleFieldInDB($columnTo['code'], $wellId, Carbon::parse($date), $copyValue);


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

    protected function getFieldByCode(string $code)
    {
        return $this->getFields()->where('code', $code)->first();
    }

    protected function getFilterTree(): array
    {
        return [];
    }

    protected function getFields(): Collection
    {
        return collect($this->params()['columns']);
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

    private function getFieldHistory(array $fieldParams, Collection $collection, Model $item)
    {
        $result = [];
        if (is_null($collection->get($item->id))) {
            return $result;
        }

        $rows = $collection->get($item->id);
        if (!empty($fieldParams['additional_filter'])) {
            foreach ($fieldParams['additional_filter'] as $key => $value) {
                $rows->where($key, '=', $value);
            }
        }

        if ($rows->isEmpty()) {
            return $result;
        }

        foreach ($rows as $row) {
            $date = Carbon::parse($row->dbeg)->format('d.m.Y');
            if (isset($result[$date])) {
                continue;
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

            $result[$date] = ['value' => $value, 'time' => Carbon::parse($row->dbeg)->format('d.m.Y H:i:s')];
        }

        return $result;
    }

    protected function getFormatedFieldValue(array $field, array $value): ?array
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

        if (empty($row)) {
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

    protected function fetchRowData(Collection $tables, array $wellIds, Carbon $date, Carbon $dateFrom = null): array
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

    private function getRowHistoryColumnCodes($columnCode, $fieldsParam = 'fields')
    {
        $result = [];
        $column = $this->getFieldByCode($columnCode);
        $columnCodes = $column[$fieldsParam];
        foreach ($this->getFields()->whereIn('code', $columnCodes) as $column) {
            $result[] = $column['code'];
            if ($column['type'] === 'calc') {
                if (preg_match_all('#\$([\S]*)\$#', $column['formula'], $matches)) {
                    $result = array_merge($result, $matches[1]);
                }
            }
        }

        return array_values(array_unique($result));
    }

    private function groupFieldsByDates(array $fields, Carbon $dateFrom, Carbon $dateTo)
    {
        $result = [];

        while ($dateFrom <= $dateTo) {
            $date = $dateFrom->format('d.m.Y');

            $dateValues = [];
            foreach ($fields as $code => $field) {
                $dateValues[$code] = isset($field[$date]) ? $field[$date] : null;
            }
            $result[$date] = $dateValues;

            $dateFrom->addDay();
        }
        return $result;
    }
}