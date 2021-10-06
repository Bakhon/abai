<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use App\Traits\BigData\Forms\WithDocumentsUpload;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Gdis extends PlainForm
{
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;
    use WithDocumentsUpload;

    protected $configurationFileName = 'gdis';

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('depth'))) {
            $errors['depth'] = trans('bd.validation.depth');
        }
        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('research_date'),
            'dict.well',
            'drill_start_date'
        )) {
            $errors['research_date'] = trans('bd.validation.date');
        }

        return $errors;
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
                $data[$key] = $value;
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

            $this->submittedData['fields'] = $data;
            $this->submittedData['id'] = $id;

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

            $id = $dbQuery->insertGetId($data);

            foreach ($gdisComplexValues as $metricId => $value) {
                $this->insertComplexValue($id, $metricId, $value);
            }
        }

        $this->insertInnerTable($id);

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
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

            $rowGdisComplexValues = $gdisComplexValues->where('gdis_complex', $row->id);
            foreach ($rowGdisComplexValues as $value) {
                $row->{$value->code} = $value->value_string;
            }

            return $row;
        });
    }

}
