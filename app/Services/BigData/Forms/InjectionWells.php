<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InjectionWells extends PlainForm
{
    protected $configurationFileName = 'injection_wells';

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

    protected function isValidQmax($volume, $qmax): bool
    {
        return $qmax >= $volume;    
    }


    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidQmax($this->request->get('agent_vol'), $this->request->get('q_max_intake'))) {
            $errors['qmax'] = trans('bd.validation.qmax');
        }

        return $errors;
    }

}