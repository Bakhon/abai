<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DepthValidationTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WellTreat extends TableForm
{
    protected $configurationFileName = 'well_treat';
    use DepthValidationTrait;

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->treatment_type)) {
            throw new \Exception('Выберите вид обработки');
        }

        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, []);
        $date = Carbon::parse($filter->date)->toImmutable();

        $rowData = DB::connection('tbd')
            ->table('prod.well_treatment')
            ->whereIn('well', $wells->pluck('id')->toArray())
            ->where('treatment_type', $filter->treatment_type)
            ->where('treat_date', '>=', $date->startOfDay())
            ->where('treat_date', '<=', $date->endOfDay())
            ->orderBy('treat_date', 'desc')
            ->get();

        $wells->transform(
            function ($item) use ($rowData) {
                $result = [
                    'id' => $item->id,
                    'uwi' => ['value' => $item->uwi]
                ];

                foreach ($this->getFields() as $field) {
                    if ($field['code'] === 'uwi') {
                        continue;
                    }
                    $rowItem = $rowData->where('well', $item->id)->first();
                    $fieldValue = ['value' => $rowItem ? $rowItem->{$field['column']} : null];
                    if (!empty($fieldValue)) {
                        $result[$field['code']] = $fieldValue;
                    }
                }
                return $result;
            }
        );

        $this->addLimits($wells);

        return [
            'rows' => $wells->toArray()
        ];
    }

    public function submitForm(array $fields, array $filter = []): array
    {
        $date = Carbon::parse($filter['date'])->toImmutable();
        foreach ($fields as $wellId => $wellFields) {
            foreach ($wellFields as $columnCode => $field) {
                $column = $this->getFieldByCode($columnCode);

                $row = DB::connection('tbd')
                    ->table($column['table'])
                    ->where('well', $wellId)
                    ->whereBetween(
                        'treat_date',
                        [
                            $date->startOfDay(),
                            $date->endOfDay()
                        ]
                    )
                    ->where('treatment_type', $filter['treatment_type'])
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
                        'treatment_type' => $filter['treatment_type'],
                        'treat_date' => $date,
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

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('scraper_income'))) {
            $errors['scraper_income'][] = trans('bd.validation.depth');
        }

        return $errors;
    }
}