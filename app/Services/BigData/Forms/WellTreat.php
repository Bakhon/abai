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
        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($this->request->get('date'))
        );

        $wells->transform(
            function ($item) use ($rowData) {
                $result = [];

                foreach ($this->getFields() as $field) {
                    $fieldValue = $this->getFieldValue($field, $rowData, $item);
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

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('scraper_income'))) {
            $errors['scraper_income'][] = trans('bd.validation.depth');
        }

        return $errors;
    }
}