<?php


namespace App\Services\BigData;


use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlainFormInnerTableService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function submitTables(int $parentId, ?Collection $tableFields)
    {
        if (empty($tableFields)) {
            return null;
        }

        $submittedData = [];

        foreach ($tableFields as $field) {
            if (!empty($this->request->get($field['code']))) {
                $submittedData[$field['code']] = $this->submitTable($field, $parentId);
            }
        }

        return $submittedData;
    }

    public function submitTable($field, int $parentId): array
    {
        $submittedData = [];

        foreach ($this->request->get($field['code']) as $data) {
            if ($data['id']) {
                $this->updateRow($field['table'], $data['id'], $data);
            } else {
                $data[$field['parent_column']] = $parentId;
                $this->insertRow($field['table'], $data);
            }
            $submittedData[] = $data;
        }

        $this->removeDeletedRows($field, $parentId);

        return $submittedData;
    }

    private function updateRow(string $table, int $id, array $data)
    {
        DB::connection('tbd')
            ->table($table)
            ->where('id', $id)
            ->update($data);
    }

    private function insertRow(string $table, array $data)
    {
        DB::connection('tbd')
            ->table($table)
            ->insert($data);
    }

    private function removeDeletedRows(array $field, int $parentId)
    {
        $ids = collect($this->request->get($field['code']))->map(function ($item) {
            return $item['id'] ?? null;
        })->filter()->toArray();

        DB::connection('tbd')
            ->table($field['table'])
            ->where($field['parent_column'], $parentId)
            ->whereNotIn('id', $ids)
            ->delete();
    }
}