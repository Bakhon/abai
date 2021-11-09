<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Services\BigData\FieldLimitsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductionPlan extends TableForm
{
    protected $configurationFileName = 'production_plan';
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

    const TABLE = 'prod.production_plan';

    public function getResults(): array
    {
        if ($this->request->get('type') !== 'org') {
            return [];
        }

        $filter = json_decode($this->request->get('filter'));

        $plans = DB::connection('tbd')
            ->table(self::TABLE)
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
                        'org_id' => $this->request->get('id')
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

    protected function saveSingleFieldInDB(array $params): void
    {
        $request = $this->request->all();

        $item = DB::connection('tbd')
            ->table(self::TABLE)
            ->where('org', $request['params']['org_id'])
            ->where('year', $request['params']['year'])
            ->where('month', $request['params']['month'])
            ->first();

        if (empty($item)) {
            $data = [
                'org' => $request['params']['org_id'],
                'month' => $request['params']['month'],
                'year' => $request['params']['year'],
                $request['params']['field'] => $params['value']
            ];

            DB::connection('tbd')
                ->table(self::TABLE)
                ->insert($data);
        } else {
            DB::connection('tbd')
                ->table(self::TABLE)
                ->where('id', $item->id)
                ->update(
                    [
                        $request['params']['field'] => $params['value']
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

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];
        $request = $this->request->all();

        if ($request['params']['field']) {
            $date = Carbon::parse($request['params']['year'] . '-' . $request['params']['month'] . '-01');
            $value = (int)$this->request->get($date->format('d.m.Y'));

            if ($value <= 0) {
                $errors[$field][] = trans('bd.validation.gt', ['value' => 0]);
            }
        }
        return $errors;
    }

    private function isValidLimits(int $value, array $limits): bool
    {
        if (empty($limits)) {
            return true;
        }

        if ($limits['min'] === $limits['max']) {
            return true;
        }

        return $limits['min'] <= $value && $limits['max'] >= $value;
    }

    private function calculateLimits(Carbon $date): array
    {
        $request = $this->request->all();

        $items = DB::connection('tbd')
            ->table(self::TABLE)
            ->select($request['params']['field'])
            ->where('org', $request['params']['org_id'])
            ->whereRaw(
                "TO_DATE(CONCAT(year,'-',month,'-','01'), 'YYYY-MM-DD') < TO_DATE('" . $date->format(
                    'Y-m-d'
                ) . "', 'YYYY-MM-DD')"
            )
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(30)
            ->get();

        $fieldLimitsService = app()->make(FieldLimitsService::class);
        return $fieldLimitsService->calculateColumnLimits($request['params']['field'], $items);
    }
}