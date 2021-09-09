<?php

namespace App\Traits\BigData\Forms;

use Illuminate\Support\Facades\DB;

trait HasPlannedEvents
{
    protected function insertInnerTable(int $id)
    {
        if (!empty($this->tableFields)) {
            foreach ($this->tableFields as $field) {
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