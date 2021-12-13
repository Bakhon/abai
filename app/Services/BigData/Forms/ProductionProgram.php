<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductionProgram extends TableForm
{
    protected $configurationFileName = 'production_program';
    protected $table = 'prod.production_plan';
    protected $parentColumn = 'org';

    const FIELDS = [
        'oil_production',
        'water_injection',
        'water_production',
        'liquid_production',
        'oil_injection',
        'gas_production',
        'steam_injection',
        'absorption'
    ];


    public function getResults(): array
    {
        if ($this->request->get('type') !== $this->parentColumn) {
            return [];
        }

        $filter = json_decode($this->request->get('filter'));

        $plans = DB::connection('tbd')
            ->table($this->table)
            ->where($this->parentColumn, $this->request->get('id'))
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

        $result = [];

        foreach (self::FIELDS as $fieldName) {
            $startDate = Carbon::parse($filter->date)->startOfMonth();
            $endDate = Carbon::parse($filter->date_to)->endOfMonth();
            $currentDate = $startDate;

            $row = [
                'id' => $fieldName . '_' . $currentDate->format('d.m.Y'),
                'name' => [
                    'name' => trans("bd.forms.production_program.$fieldName")
                ]
            ];

            while ($currentDate < $endDate) {
                $plan = $plans
                    ->where('year', $currentDate->year)
                    ->where('month', $currentDate->month)
                    ->first();

                $row[$currentDate->format('d.m.Y')] = [
                    'value' => $plan ? $plan->{$fieldName} : 0,
                    'params' => [
                        'field' => $fieldName,
                        'year' => $currentDate->year,
                        'month' => $currentDate->month,
                        $this->parentColumn => $this->request->get('id')
                    ]
                ];

                $currentDate->addMonthNoOverflow();
            }

            $result[] = $row;
        }

        return [
            'columns' => $this->getColumns(),
            'rows' => $result
        ];
    }

    public function submitForm(array $rows, array $filter = []): array
    {
        foreach ($rows as $row) {
            foreach ($row as $field) {
                $planId = $this->getPlanId($field);

                DB::connection('tbd')
                    ->table($this->table)
                    ->where('id', $planId)
                    ->update(
                        [
                            $field['params']['field'] => $field['value']
                        ]
                    );
            }
        }
        return [];
    }

    private function getPlanId(array $field)
    {
        $key = implode('_', [$field['params'][$this->parentColumn], $field['params']['year'], $field['params']['month']]
        );
        if (isset($this->plans[$key])) {
            return $this->plans[$key];
        }

        $plan = DB::connection('tbd')
            ->table($this->table)
            ->where($this->parentColumn, $field['params'][$this->parentColumn])
            ->where('year', $field['params']['year'])
            ->where('month', $field['params']['month'])
            ->first();

        if (!empty($plan)) {
            $this->plans[$key] = $plan->id;
            return $plan->id;
        }

        $planId = DB::connection('tbd')
            ->table($this->table)
            ->insertGetId(
                [
                    $this->parentColumn => $field['params'][$this->parentColumn],
                    'month' => $field['params']['month'],
                    'year' => $field['params']['year']
                ]
            );

        $this->plans[$key] = $planId;
        return $planId;
    }

    private function getColumns(): array
    {
        $filter = json_decode($this->request->get('filter'));
        $startDate = Carbon::parse($filter->date)->startOfMonth();
        $endDate = Carbon::parse($filter->date_to)->endOfMonth();
        $currentDate = $startDate;

        $columns = [
            [
                "code" => "name",
                "is_editable" => false,
                "title" => "Наименование",
                "type" => "label"
            ]
        ];
        while (true) {
            $columns[] = [
                "code" => $currentDate->format('d.m.Y'),
                "is_editable" => true,
                "title" => trans('app.months.' . $currentDate->format('n')) . ' ' . $currentDate->format('Y'),
                "type" => "text"
            ];

            $currentDate->addMonthNoOverflow();
            if ($currentDate >= $endDate) {
                break;
            }
        }

        return $columns;
    }
}