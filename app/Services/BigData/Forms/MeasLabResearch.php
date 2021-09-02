<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class MeasLabResearch extends TableForm
{
    protected $configurationFileName = 'meas_lab_research';

    public function getRows(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->research_type)) {
            throw new \Exception('Выберите вид исследования');
        }

        //$wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filterValues, $params);

        $columns = $this->getColumns($filter);

        $rows = [
            [
                'id' => 1,
                'uwi' => [
                    'href' => '#'
                ]
            ]
        ];

        return [
            'columns' => $columns,
            'rows' => $rows
        ];
    }

    private function getColumns(\stdClass $filterValues)
    {
        $dictionaryService = app()->make(\App\Services\BigData\DictionaryService::class);
        $filterFields = collect($this->params()['filter']);

        $fields = $this->getFields()
            ->filter(function ($field) use ($filterFields, $filterValues, $dictionaryService) {
                if (!isset($field['depends_on'])) {
                    return true;
                }


                foreach ($field['depends_on'] as $dependency) {
                    $filterField = $filterFields->where('code', $dependency['field'])->first();
                    $dict = collect($dictionaryService->get($filterField['dict']));

                    $code = $dependency['value']['code'];

                    $dictItem = $dict->where('code', $code)
                        ->where('id', $filterValues->{$filterField['code']})
                        ->first();

                    if (empty($dictItem)) {
                        return false;
                    }
                }

                return true;
            });

        return $fields;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
    }
}