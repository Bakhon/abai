<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductionWell extends PlainForm
{
    protected $configurationFileName = 'production_well';

    public function calcFields(int $wellId, array $values): array
    {
        $requiredFields = ['liquid', 'wcut', 'oil_density'];
        foreach ($requiredFields as $field) {
            if (empty($values[$field])) {
                return [];
            }
        }

        $oil = round($values['liquid'] * (1 - $values['wcut'] / 100) * $values['oil_density'], 2);
        return [
            'oil' => $oil
        ];
    }

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
}