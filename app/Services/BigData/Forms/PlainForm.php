<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

abstract class PlainForm extends BaseForm
{
    protected $jsonValidationSchemeFileName = 'plain_form.json';

    protected function getFields(): \Illuminate\Support\Collection
    {
        $fields = collect();
        foreach ($this->params()['tabs'] as $tab) {
            foreach ($tab['blocks'] as $block) {
                foreach ($block as $subBlock) {
                    foreach ($subBlock['items'] as $item) {
                        $fields[] = $item;
                    }
                }
            }
        }

        return $fields;
    }

    public function submit(): array
    {
        $tableFields = $this->getFields()
            ->filter(
                function ($item) {
                    return $item['type'] === 'table';
                }
            );

        $tableFieldCodes = $tableFields
            ->pluck('code')
            ->toArray();

        $data = $this->request->except($tableFieldCodes);

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        if (!empty($data['id'])) {
            $id = $dbQuery->where('id', $data['id'])->update($data);
        } else {
            $id = $dbQuery->insertGetId($data);
        }

        if (!empty($tableFields)) {
            foreach ($tableFields as $field) {
                foreach ($this->request->get($field['code']) as $data) {
                    $data[$field['parent_column']] = $id;
                    DB::connection('tbd')->table($field['table'])->insert($data);
                }
            }
        }

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }

    public function getResults(int $wellId): JsonResponse
    {
        try {
            $query = DB::connection('tbd')
                ->table($this->params()['table'])
                ->where('well', $wellId)
                ->orderBy('id', 'desc');

            if (isset($this->params()['table_fields'])) {
                $query->select(array_merge(['id'], $this->params()['table_fields']));
            }
            $rows = $query->get();

            $columns = $this->getFields()->filter(
                function ($item) {
                    if (isset($this->params()['table_fields'])) {
                        return in_array($item['code'], $this->params()['table_fields']);
                    }

                    return $item['type'] !== 'table';
                }
            )
                ->mapWithKeys(
                    function ($item) {
                        return [$item['code'] => $item];
                    }
                );

            return response()->json(
                [
                    'rows' => $rows,
                    'columns' => $columns
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete(int $rowId)
    {
        DB::connection('tbd')
            ->table($this->params()['table'])
            ->delete($rowId);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

}