<?php


namespace App\Services\BigData\Forms\RowHistory;


use App\Models\BigData\Well;
use App\Services\BigData\Forms\TableForm;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RowHistory
{

    protected $form;

    public function __construct(TableForm $form)
    {
        $this->form = $form;
    }

    public function getRowHistoryGraph(int $wellId, string $column, Carbon $dateTo, Carbon $dateFrom = null)
    {
        $well = Well::find($wellId);

        $graphColumnCodes = $this->getRowHistoryColumnCodes($column, 'graph_fields');
        $tables = $this->form
            ->getFields()
            ->whereIn('code', $graphColumnCodes)
            ->pluck('table')
            ->filter()
            ->unique();

        $rowData = $this->form->fetchRowData($tables, (array)$well->id, $dateTo, (clone $dateTo)->subYears(10));

        $result = [];
        foreach ($this->form->getFields()->whereIn('code', $graphColumnCodes) as $field) {
            if (empty($field['table'])) {
                $result[$field['code']] = [];
                continue;
            }

            $result[$field['code']] = array_map(
                function ($item) use ($field) {
                    return $this->form->getFormatedFieldValue($field, $item);
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
            'selectedColumn' => $column,
            'table' => [
                'rows' => $this->getRowHistory($wellId, $column, $dateTo, $dateFrom),
                'columns' => $this->getRowHistoryColumnCodes($column)
            ],
            'graph' => [
                'rows' => $this->groupFieldsByDates($result, $minDate, $dateTo),
                'columns' => $this->form->getFieldByCode($column)['graph_fields']
            ]
        ];
    }

    private function getRowHistoryColumnCodes($columnCode, $fieldsParam = 'fields')
    {
        $result = [];
        $column = $this->form->getFieldByCode($columnCode);

        $columnCodes = [];
        foreach ($column[$fieldsParam] as $block) {
            $columnCodes = array_merge($columnCodes, $this->getBlockColumnCodes($block));
        }

        foreach ($this->form->getFields()->whereIn('code', $columnCodes) as $column) {
            $result[] = $column['code'];
            if ($column['type'] === 'calc') {
                if (preg_match_all('#\$([\S]*)\$#', $column['formula'], $matches)) {
                    $result = array_merge($result, $matches[1]);
                }
            }
        }

        return array_values(array_unique($result));
    }

    private function getBlockColumnCodes($block)
    {
        $columnCodes = [];
        foreach ($block as $column => $columnParams) {
            $columnCodes[] = $column;
        }
        return $columnCodes;
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

    public function getRowHistory(int $wellId, string $column, Carbon $dateTo, Carbon $dateFrom = null)
    {
        if (is_null($dateFrom)) {
            $dateFrom = (clone $dateTo)->subMonthNoOverflow();
        }

        $well = Well::find($wellId);
        $columnCodes = $this->getRowHistoryColumnCodes($column);

        $tables = $this->form
            ->getFields()
            ->whereIn('code', $columnCodes)
            ->pluck('table')
            ->filter()
            ->unique();

        $rowData = $this->form->fetchRowData($tables, (array)$well->id, $dateTo, $dateFrom);

        $result = [];
        foreach ($this->form->getFields()->whereIn('code', $columnCodes) as $field) {
            if (empty($field['table'])) {
                $result[$field['code']] = [];
                continue;
            }

            $result[$field['code']] = array_map(
                function ($item) use ($field) {
                    return $this->form->getFormatedFieldValue($field, $item);
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