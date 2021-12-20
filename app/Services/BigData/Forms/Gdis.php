<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\WithDocumentsUpload;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Gdis extends PlainForm
{
    use DateMoreThanValidationTrait;
    use WithDocumentsUpload;

    protected $configurationFileName = 'gdis';
    protected $metricColumns;

    protected function params(): array
    {
        $params = parent::params();
        $params['tabs'][0]['blocks'][0][0]['items'] = array_merge(
            $params['tabs'][0]['blocks'][0][0]['items'],
            $this->getMetricColumns()
        );
        return $params;
    }

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('dbeg'),
            'dict.well',
            'drill_start_date'
        )) {
            $errors['dbeg'] = trans('bd.validation.date');
        }

        return $errors;
    }

    protected function getMetricColumns()
    {
        if ($this->metricColumns) {
            return $this->metricColumns;
        }

        $metrics = DB::connection('tbd')
            ->table('dict.metric as m')
            ->select('m.code', 'm.name_ru', 'rm.id', 'm.data_type', 'm.value_double_min', 'm.value_double_max')
            ->join('prod.gdis_method_metric as gmm', 'm.id', 'gmm.metric')
            ->join('dict.research_method as rm', 'gmm.research_method', 'rm.id')
            ->where('rm.gdis_complex', true)
            ->get();

        foreach ($metrics as $metric) {
            $validation = [];
            if ($metric->value_double_min) {
                $validation[] = 'gte:' . $metric->value_double_min;
            }
            if ($metric->value_double_max) {
                $validation[] = 'lte:' . $metric->value_double_max;
            }
            $validation = implode('|', $validation);

            $columns[] = [
                'code' => $metric->code,
                'table' => 'prod.gdis_complex_value',
                'type' => 'numeric',
                'title' => $metric->name_ru,
                'validation' => $validation,
                'depends_on' => [
                    [
                        'field' => 'method',
                        'value' => $metric->id
                    ]
                ]
            ];
        }

        $this->metricColumns = $columns;

        return $columns;
    }

    protected function getRows(): Collection
    {
        $rows = parent::getRows();

        if (!empty($rows)) {
            $documents = $this->getAttachedDocuments($rows->pluck('id')->toArray());
            $rows = $rows->map(function ($row) use ($documents) {
                if ($documents->get($row->id)) {
                    $row->documents = $documents->get($row->id)->toArray();
                }
                return $row;
            });
        }

        return $rows;
    }

    protected function submitForm(): array
    {
        $this->tableFields = $this->getFields()
            ->filter(
                function ($item) {
                    return $item['type'] === 'table';
                }
            );

        $this->tableFieldCodes = $this->tableFields
            ->pluck('code')
            ->toArray();

        $metrics = DB::connection('tbd')
            ->table('dict.metric')
            ->select('id', 'name_ru', 'code')
            ->get();

        $tmpData = $this->prepareDataToSubmit();
        $gdisComplexValueFieldsCodes = $this->getFields()->filter(function ($field) {
            return !empty($field['table']) && $field['table'] === 'prod.gdis_complex_value';
        })->pluck('code')->unique()->toArray();

        $data = $gdisComplexValues = [];
        foreach ($tmpData as $key => $value) {
            if (in_array($key, $gdisComplexValueFieldsCodes)) {
                $metric = $metrics->where('code', $key)->first();
                if (empty($metric)) {
                    continue;
                }
                $gdisComplexValues[$metric->id] = $value;
            } else {
                if($key === 'id' || $this->getFields()->where('code', $key)->isNotEmpty()) {
                    $data[$key] = $value;
                }
            }
        }

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        if (!empty($data['id'])) {
            $this->checkFormPermission('create');

            $id = $data['id'];
            unset($data['id']);

            $dbQuery = $dbQuery->where('id', $id);

            $this->originalData = $dbQuery->first();
            $dbQuery->update($data);

            foreach ($gdisComplexValues as $metricId => $value) {
                $gdisComplexValue = DB::connection('tbd')
                    ->table('prod.gdis_complex_value')
                    ->where('gdis_complex', $id)
                    ->where('metric', $metricId)
                    ->first();

                if (!empty($gdisComplexValue)) {
                    DB::connection('tbd')
                        ->table('prod.gdis_complex_value')
                        ->where('id', $gdisComplexValue->id)
                        ->update(
                            [
                                'value_string' => $value
                            ]
                        );
                } else {
                    $this->insertComplexValue($id, $metricId, $value);
                }
            }
        } else {
            $this->checkFormPermission('create');

            $this->originalData = [];
            $id = $dbQuery->insertGetId($data);

            foreach ($gdisComplexValues as $metricId => $value) {
                $this->insertComplexValue($id, $metricId, $value);
            }
        }

        $this->submittedData['fields'] = $data;
        $this->submittedData['id'] = $id;

        $this->submitInnerTable($id);

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }

    protected function prepareDataToSubmit()
    {
        $data = parent::prepareDataToSubmit();
        return array_filter(
            $data,
            function ($key) {
                return !in_array($key, ['documents', 'research_results']);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    protected function insertComplexValue(int $id, int $metricId, $value)
    {
        DB::connection('tbd')
            ->table('prod.gdis_complex_value')
            ->insert(
                [
                    'gdis_complex' => $id,
                    'metric' => $metricId,
                    'value_string' => $value
                ]
            );
    }

    protected function formatRows(Collection $rows): Collection
    {
        $rowIds = $rows->pluck('id')->toArray();

        $gdisComplexValues = DB::connection('tbd')
            ->table('prod.gdis_complex_value as g')
            ->select('g.gdis_complex', 'm.code', 'g.value_string')
            ->whereIn('gdis_complex', $rowIds)
            ->join('dict.metric as m', 'm.id', 'g.metric')
            ->get();

        return $rows->map(function ($row) use ($gdisComplexValues) {
            if (isset($row->dend)) {
                if (Carbon::parse($row->dend) > Carbon::parse('01-01-3000')) {
                    $row->dend = null;
                }
            }

            $researchResults = [];
            $rowGdisComplexValues = $gdisComplexValues->where('gdis_complex', $row->id);
            foreach ($rowGdisComplexValues as $value) {
                $field = $this->getFields()->where('code', $value->code)->first();
                $researchResults[] = ($field ? $field['title'] : $value->code) . ': ' . $value->value_string;
                $row->{$value->code} = $value->value_string;
            }

            $row->research_results = implode(', ', $researchResults);

            return $row;
        });
    }

}
