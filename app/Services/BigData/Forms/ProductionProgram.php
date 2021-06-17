<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductionProgram extends TableForm
{
    protected $configurationFileName = 'production_program';

    public function getRows(array $params = [])
    {
        if ($this->request->get('type') !== 'org') {
            return [];
        }

        $filter = json_decode($this->request->get('filter'));

        $result = DB::connection('tbd')
            ->table('prod.production_plan')
            ->where('org', $this->request->get('id'))
            ->whereRaw(
                "TO_DATE(CONCAT(year,'-',month,'-','01'), 'YYYY-MM-DD') >= TO_DATE('" . Carbon::parse(
                    $filter->date
                )->format('Y-m-d') . "', 'YYYY-MM-DD')"
            )
            ->whereRaw(
                "TO_DATE(CONCAT(year,'-',month,'-','01'), 'YYYY-MM-DD') <= TO_DATE('" . Carbon::parse(
                    $filter->date_to
                )->format('Y-m-d') . "', 'YYYY-MM-DD')"
            )
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return [
            'rows' => $result->toArray()
        ];
    }

    protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void
    {
        $column = $this->getFieldByCode($field);

        if (empty($item)) {
            $data = [
                'well' => $wellId,
                $column['column'] => $value,
                'dbeg' => $date->toDateTimeString()
            ];

            if (!empty($column['additional_filter'])) {
                foreach ($column['additional_filter'] as $key => $val) {
                    $data[$key] = $val;
                }
            }

            DB::connection('tbd')
                ->table($column['table'])
                ->insert($data);
        } else {
            DB::connection('tbd')
                ->table($column['table'])
                ->where('id', $item->id)
                ->update(
                    [
                        $column['column'] => $value
                    ]
                );
        }
    }
}