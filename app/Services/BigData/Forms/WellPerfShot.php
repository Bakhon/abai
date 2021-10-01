<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Models\BigData\Well;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Facades\DB;

class WellPerfShot extends PlainForm
{
    protected $configurationFileName = 'well_perf_shot';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('depth'))) {
            $errors['depth'] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('base'))) {
            $errors['base'] = trans('bd.validation.depth');
        }
        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('perf_date'),
            'dict.well',
            'drill_end_date'
        )) {
            $errors['perf_date'] = trans('bd.validation.perf_date');
        }
        return $errors;
    }

    protected function insertInnerTable(int $id)
    {
        if (!empty($this->tableFields)) {
            foreach ($this->tableFields as $field) {
                if (!empty($this->request->get($field['code']))) {
                    $this->submittedData['table_fields'][$field['code']] = [];
                    foreach ($this->request->get($field['code']) as $data) {
                        $data[$field['parent_column']] = $id;
                        $data['dbeg'] = $this->request->get('perf_date');
                        $data['dend'] = Well::DEFAULT_END_DATE;
                        $this->submittedData['table_fields'][$field['code']][] = $data;
                        DB::connection('tbd')->table($field['table'])->insert($data);
                    }
                }
            }
        }
    }
}