<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;

class ProductionWell extends PlainForm
{
    protected $configurationFileName = 'production_well';

    protected function insertInnerTable(\Illuminate\Support\Collection $tableFields, int $id)
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
}