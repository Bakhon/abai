<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\LabResearchType;
use App\Models\BigData\Dictionaries\Metric;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResearchLabResearch extends PlainForm
{
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;

    protected $configurationFileName = 'research_lab_research';

    protected function getRows(): Collection
    {
        $rows = parent::getRows();

        $researchValues = DB::connection('tbd')
            ->table('prod.lab_research_value as lrv')
            ->select('lrv.value_double', 'lrv.value_text', 'lrv.research', 'm.code')
            ->join('dict.metric as m', 'lrv.param', 'm.id')
            ->whereIn('lrv.research', $rows->pluck('id')->toArray())
            ->get()
            ->groupBy('research');

        $rows->map(function ($row) use ($researchValues) {
            $rowResearchValues = $researchValues->get($row->id);
            if (empty($rowResearchValues)) {
                return $row;
            }

            $researchResults = [];
            foreach ($rowResearchValues as $rowResearchValue) {
                $field = $this->getFields()->where('code', $rowResearchValue->code)->first();
                $value = $rowResearchValue->value_double ?? $rowResearchValue->value_text;
                $researchResults[] = ($field ? $field['title'] : $rowResearchValue->code) . ': ' . $value;
                $row->{$rowResearchValue->code} = $value;
            }
            $row->research_results = implode(', ', $researchResults);

            return $row;
        });

        return $this->formatRows($rows);
    }

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
        $researchType = LabResearchType::find($this->request->get('research_type'));
        $mainFields = $this->getFields()
            ->filter(function ($field) use ($researchType) {
                return empty($field['depends_on']);
            });

        $data = $this->request->all();
        $mainData = array_filter(
            $data,
            function ($value, $key) use ($mainFields) {
                if (in_array($key, ['research_results'])) {
                    return false;
                }
                if ($key === 'well') {
                    return true;
                }
                return $mainFields->where('code', $key)->isNotEmpty();
            },
            ARRAY_FILTER_USE_BOTH
        );

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        if (!empty($data['id'])) {
            $this->checkFormPermission('update');

            $researchId = $data['id'];
            unset($data['id']);

            $dbQuery = $dbQuery->where('id', $researchId);

            $this->originalData = $dbQuery->first();
            $dbQuery->update($mainData);

            $this->submittedData['fields'] = $mainData;
            $this->submittedData['id'] = $researchId;
        } else {
            $this->checkFormPermission('create');

            $researchId = $dbQuery->insertGetId($mainData);
        }

        $this->saveDependentFields($researchId, $researchType, $data);

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $researchId)->first();
    }

    private function saveDependentFields(int $researchId, LabResearchType $researchType, array $data)
    {
        $dependentFields = $this->getFields()
            ->filter(function ($field) use ($researchType) {
                if (empty($field['depends_on'])) {
                    return false;
                }

                foreach ($field['depends_on'] as $dependency) {
                    return $dependency['value']['code'] === $researchType->code;
                }

                return false;
            });

        $dependentData = array_filter(
            $data,
            function ($value, $key) use ($dependentFields) {
                return $dependentFields->where('code', $key)->isNotEmpty();
            },
            ARRAY_FILTER_USE_BOTH
        );

        $metrics = Metric::whereIn('code', $dependentFields->pluck('code')->toArray())->get();

        $dependentRows = DB::connection('tbd')
            ->table('prod.lab_research_value as lrv')
            ->select('lrv.id', 'lrv.value_double', 'lrv.value_text', 'lrv.research', 'm.code')
            ->join('dict.metric as m', 'lrv.param', 'm.id')
            ->where('lrv.research', $researchId)
            ->get();

        foreach ($dependentData as $key => $value) {
            $metric = $metrics->where('code', $key)->first();
            $dependentRow = $dependentRows->where('code', $key)->first();
            $dependentField = $dependentFields->where('code', $key)->first();
            $valueColumn = $dependentField['type'] === 'numeric' ? 'value_double' : 'value_text';

            if (empty($dependentRow)) {
                DB::connection('tbd')
                    ->table('prod.lab_research_value as lrv')
                    ->insert(
                        [
                            'research' => $researchId,
                            'param' => $metric->id,
                            $valueColumn => $value
                        ]
                    );
            } else {
                DB::connection('tbd')
                    ->table('prod.lab_research_value as lrv')
                    ->where('id', $dependentRow->id)
                    ->update(
                        [
                            $valueColumn => $value
                        ]
                    );
            }
        }
    }
}