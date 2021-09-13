<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\LabResearchType;
use App\Exceptions\BigData\SubmitFormException;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResearchLabResearch extends PlainForm
{
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;

    const TABLES_BY_TYPE = [
        'PVTD' => 'prod.pvt_data',
        'ADSPO' => 'prod.reservoir_oil_prob_analysis',
        'AEF' => 'prod.produced_water_analysis',
        'OCRC' => 'prod.res_oil_char',
        'COSC' => 'prod.surf_oil_characteristics'
    ];

    protected $configurationFileName = 'research_lab_research';

    protected function getRows(int $wellId): Collection
    {
        $query = DB::connection('tbd')
            ->table('prod.lab_research as lr')
            ->select('lr.id', 'research_type', 'research_date', 'lrt.code as research_type_code')
            ->where('well', $wellId)
            ->join('dict.lab_research_type as lrt', 'lr.research_type', 'lrt.id')
            ->orderBy('id', 'desc');

        $rows = $query->get();

        if (!empty($this->params()['sort'])) {
            foreach ($this->params()['sort'] as $sort) {
                if ($sort['order'] === 'desc') {
                    $rows->sortByDesc($sort['field']);
                } else {
                    $rows->sortBy($sort['field']);
                }
            }
        }

        $rows->map(function ($row) {
            if (!isset(self::TABLES_BY_TYPE[$row->research_type_code])) {
                return $row;
            }
            $additionalData = DB::connection('tbd')
                ->table(self::TABLES_BY_TYPE[$row->research_type_code])
                ->where('well', $row->id)
                ->first();
            unset($additionalData->id, $additionalData->well);

            foreach ((array)$additionalData as $key => $value) {
                $row->$key = $value;
            }
            return $row;
        });

        return $this->formatRows($rows);
    }

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

    protected function submitForm(): array
    {
        $researchType = LabResearchType::find($this->request->get('research_type'));
        $mainFields = $this->getFields()
            ->filter(function ($field) use ($researchType) {
                return !empty($field['depends_on']);
            });

        $dependentFields = $this->getFields()
            ->filter(function ($field) use ($researchType) {
                return !empty($field['depends_on']);
                foreach ($field['depends_on'] as $dependency) {
                    return $dependency['value']['code'] === $researchType->code;
                }

                return false;
            });

        $dependentTable = self::TABLES_BY_TYPE[$researchType->code];

        $data = $this->request->all();
        $mainData = array_filter($data, function ($value, $key) use ($mainFields) {
            return $mainFields->where('code', $key)->isNotEmpty();
        },                       ARRAY_FILTER_USE_BOTH);

        $dependentData = array_filter($data, function ($value, $key) use ($dependentFields) {
            return $dependentFields->where('code', $key)->isNotEmpty();
        },                            ARRAY_FILTER_USE_BOTH);


        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        if (!empty($data['id'])) {
            $this->checkFormPermission('update');

            $id = $data['id'];
            unset($data['id']);

            $dbQuery = $dbQuery->where('id', $id);

            $this->originalData = $dbQuery->first();
            $dbQuery->update($mainData);

            $this->submittedData['fields'] = $mainData;
            $this->submittedData['id'] = $id;
        } else {
            $this->checkFormPermission('create');

            $id = $dbQuery->insertGetId($mainData);
        }

        $dependentRow = DB::connection('tbd')
            ->table($dependentTable)
            ->where('well', $id)
            ->first();

        if (empty($dependentRow)) {
            DB::connection('tbd')
                ->table($dependentTable)
                ->insert(
                    array_merge(
                        [
                            'well' => $id
                        ],
                        $dependentData
                    )
                );
        } else {
            DB::connection('tbd')
                ->table($dependentTable)
                ->where('id', $dependentRow->id)
                ->update($dependentData);
        }

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }

}