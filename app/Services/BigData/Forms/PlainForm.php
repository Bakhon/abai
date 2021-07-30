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
            if (!empty($this->params()['default_values'])) {
                $data = array_merge($this->params()['default_values'], $data);
            }

            $dbQuery = DB::connection('tbd')->table($this->params()['table']);

            if (!empty($data['id'])) {
                $id = $dbQuery->where('id', $data['id'])->update($data);
            } else {
                $id = $dbQuery->insertGetId($data);
            }

            $this->insertInnerTable($tableFields, $id);

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

            if (!empty($this->params()['sort'])) {
                foreach ($this->params()['sort'] as $sort) {
                    if ($sort['order'] === 'desc') {
                        $rows->sortByDesc($sort['field']);
                    } else {
                        $rows->sortBy($sort['field']);
                    }
                }
            }


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
                    'rows' => $rows->values(),
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

    protected function insertInnerTable(Collection $tableFields, int $id)
    {
        if (!empty($tableFields)) {
            foreach ($tableFields as $field) {
                if (!empty($this->request->get($field['code']))) {
                    foreach ($this->request->get($field['code']) as $data) {
                        $data[$field['parent_column']] = $id;
                        DB::connection('tbd')->table($field['table'])->insert($data);
                    }
                }
            }
        }
    }

}