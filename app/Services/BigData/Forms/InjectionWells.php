<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InjectionWells extends PlainForm
{
    protected $configurationFileName = 'injection_wells';
    use DateMoreThanValidationTrait;

    protected function insertInnerTable(Collection $tableFields, int $id)
    {
        if (!empty($tableFields)) {
            foreach ($tableFields as $field) {
                if (!empty($this->request->get($field['code']))) {
                    foreach ($this->request->get($field['code']) as $data) {
                        $data['well'] = $this->request->get('well');
                        DB::connection('tbd')->table($field['table'])->insert($data);
                    }
                }
            }
        }
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDateDbeg($this->request->get('well'),$this->request->get('dbeg'), 'prod.tech_mode_inj', 'dend')){
            $errors['dbeg'] = trans('bd.validation.dbeg');
        }

        return $errors;
    }

}