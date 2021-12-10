<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

abstract class TechModeForm extends TableForm
{
    public function submitForm(array $fields, array $filter = []): array
    {
        foreach ($fields as $wellId => $wellFields) {
            foreach ($wellFields as $columnCode => $field) {
                $column = $this->getFieldByCode($columnCode);

                $this->insertValueInCell(
                    $column['table'],
                    $column['column'],
                    null,
                    $wellId,
                    $filter['date'],
                    $field['value']
                );
            }
        }
        return [];
    }

}