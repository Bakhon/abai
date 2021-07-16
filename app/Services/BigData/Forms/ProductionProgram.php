<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductionProgram extends TableForm
{
    protected $configurationFileName = 'production_program';

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

    public function getRows(array $params = []): array
    {
        if ($this->request->get('type') !== 'org') {
            return [];
        }

        $filter = json_decode($this->request->get('filter'));

        $plans = DB::connection('tbd')
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

        $result = [];

        foreach (self::FIELDS as $fieldName) {
            $startDate = Carbon::parse($filter->date)->startOfMonth();
            $endDate = Carbon::parse($filter->date_to)->endOfMonth();
            $currentDate = $startDate;

            $row = [
                'name' => [
                    'name' => trans("bd.forms.production_program.$fieldName")
                ]
            ];

            while (true) {
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
                    ]
                ];

                $currentDate->addMonthNoOverflow();
                if ($currentDate >= $endDate) {
                    break;
                }
            }

            $result[] = $row;
        }

        return [
            'columns' => $this->getColumns(),
            'rows' => $result
        ];
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        $column = $this->getFieldByCode($params['field']);

        $item = $this->getFieldRow($column, $params['wellId'], $params['date']);

        if (empty($item)) {
            $data = [
                'well' => $params['wellId'],
                $column['column'] => $params['value'],
                'dbeg' => $params['date']->toDateTimeString()
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
                        $column['column'] => $params['value']
                    ]
                );
        }
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