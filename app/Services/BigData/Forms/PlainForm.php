<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class PlainForm extends BaseForm
{
    protected $jsonValidationSchemeFileName = 'plain_form.json';
    protected $tableFields;
    protected $tableFieldCodes;

    protected function getFields(): Collection
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
        DB::connection('tbd')->beginTransaction();

        try {
            $this->tableFields = $this->getFields()
                ->filter(
                    function ($item) {
                        return $item['type'] === 'table';
                    }
                );

            $this->tableFieldCodes = $this->tableFields
                ->pluck('code')
                ->toArray();

            $data = $this->prepareDataToSubmit();
            $dbQuery = DB::connection('tbd')->table($this->params()['table']);

            if (!empty($data['id'])) {
                $id = $dbQuery->where('id', $data['id'])->update($data);
            } else {
                $id = $dbQuery->insertGetId($data);
            }

            $this->insertInnerTable($id);

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }

    public function getResults(int $wellId): JsonResponse
    {
        try {
            $query = DB::connection('tbd')
                ->table($this->params()['table'])
                ->where('well', $wellId)
                ->orderBy('id', 'desc');

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
                    'columns' => $columns,
                    'form' => $this->params()
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

    public function getCalculatedFields(int $wellId, array $values): array
    {
        return [];
    }

    public function getUpdatedFields(int $wellId, array $values): array
    {
        return [];
    }

    public function getFormByRow(array $row): array
    {
        return [];
    }

    public function delete(int $rowId)
    {
        DB::connection('tbd')
            ->table($this->params()['table'])
            ->delete($rowId);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    protected function insertInnerTable(int $id)
    {
        if (!empty($this->tableFields)) {
            foreach ($this->tableFields as $field) {
                if (!empty($this->request->get($field['code']))) {
                    foreach ($this->request->get($field['code']) as $data) {
                        $data[$field['parent_column']] = $id;
                        DB::connection('tbd')->table($field['table'])->insert($data);
                    }
                }
            }
        }
    }

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);
        if (!empty($this->params()['default_values'])) {
            $data = array_merge($this->params()['default_values'], $data);
        }
        return $data;
    }

}