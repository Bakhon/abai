<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Exceptions\BigData\SubmitFormException;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResearchLabResearch extends PlainForm
{
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;
    protected $configurationFileName = 'research_lab_research';
    protected function getCustomValidationErrors(): array
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
    public function submit(): array
    {
        DB::connection('tbd')->beginTransaction();

        try {
            $id = $this->submitData();

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }

    protected function submitData()
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
            return !empty($field['table']) && $field['table'] === 'prod.pvt_data';
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
                    ->table('prod.pvt_data')
                    ->where('id', $id)
                    ->where('metric', $metricId)
                    ->first();

                if (!empty($gdisComplexValue)) {
                    DB::connection('tbd')
                        ->table('prod.pvt_data')
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

        return $id;
    }

    protected function insertComplexValue(int $id, int $metricId, $value)
    {
        DB::connection('tbd')
            ->table('prod.pvt_data')
            ->insert(
                [
                    'id' => $id,
                    'metric' => $metricId,
                    'value_string' => $value
                ]
            );
    }

    protected function formatRows(Collection $rows)
    {
        $rowIds = $rows->pluck('id')->toArray();

        $gdisComplexValues = DB::connection('tbd')
            ->table('prod.pvt_data as g')
            ->select('g.id', 'm.code', 'g.value_string')
            ->whereIn('id', $rowIds)
            ->join('dict.metric as m', 'm.id', 'g.metric')
            ->get();

        return $rows->map(function ($row) use ($gdisComplexValues) {
            if (isset($row->dend)) {
                if (Carbon::parse($row->dend) > Carbon::parse('01-01-3000')) {
                    $row->dend = null;
                }
            }

            $rowGdisComplexValues = $gdisComplexValues->where('id', $row->id);
            foreach ($rowGdisComplexValues as $value) {
                $row->{$value->code} = $value->value_string;
            }

            return $row;
        });
    }

}