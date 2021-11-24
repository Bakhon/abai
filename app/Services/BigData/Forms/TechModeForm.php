<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;

abstract class TechModeForm extends TableForm
{
    public function submitForm(array $fields, array $filter = []): array
    {
        foreach ($fields as $wellId => $wellFields) {
            foreach ($wellFields as $columnCode => $field) {
                $column = $this->getFieldByCode($columnCode);

                $row = DB::connection('tbd')
                    ->table($column['table'])
                    ->where('well', $wellId)
                    ->where('dbeg', $filter['date'])
                    ->where('dend', $filter['date'])
                    ->first();
                if (!empty($row)) {
                    DB::connection('tbd')
                        ->table($column['table'])
                        ->where('id', $row->id)
                        ->update(
                            [
                                $column['column'] => $field['value']
                            ]
                        );
                } else {
                    $data = [
                        'well' => $wellId,
                        'dbeg' => $filter['date'],
                        'dend' => $filter['date'],
                        $column['column'] => $field['value']
                    ];

                    DB::connection('tbd')
                        ->table($column['table'])
                        ->insert($data);
                }
            }
        }
        return [];
    }

}