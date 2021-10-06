<?php

namespace App\Traits\BigData\Forms;

use Illuminate\Support\Facades\DB;

trait WithDocumentsUpload
{
    protected function insertInnerTable(int $id)
    {
        if (!empty($this->tableFields)) {
            foreach ($this->tableFields as $field) {
                if (!empty($this->request->get($field['code']))) {
                    if ($field['code'] === 'documents') {
                        $this->submitFiles($id, $field);
                        return;
                    }

                    $this->submittedData['table_fields'][$field['code']] = [];
                    foreach ($this->request->get($field['code']) as $data) {
                        $data[$field['parent_column']] = $id;
                        $this->submittedData['table_fields'][$field['code']][] = $data;
                        DB::connection('tbd')->table($field['table'])->insert($data);
                    }
                }
            }
        }
    }

    private function submitFiles($parentRowId, $field)
    {
        $values = $this->request->get('documents');

        $this->removeExistedFiles($field, $parentRowId, $values);

        if (empty($values)) {
            return;
        }

        foreach ($values as $value) {
            if (is_array($value)) {
                continue;
            }
            DB::connection('tbd')
                ->table($field['table']['name'])
                ->insert(
                    [
                        $field['table']['local_key'] => $parentRowId,
                        'file_type' => $field['table']['file_type'],
                        $field['table']['document_key'] => $value
                    ]
                );
        }
    }

    private function removeExistedFiles(array $field, int $parentRowId, array $values = null)
    {
        if ($values === null) {
            return;
        }

        $existedFiles = DB::connection('tbd')
            ->table($field['table']['name'])
            ->where($field['table']['local_key'], $parentRowId)
            ->where('file_type', $field['table']['file_type'])
            ->get();

        foreach ($existedFiles as $existedFile) {
            $value = array_filter($values, function ($item) use ($existedFile) {
                if (is_array($item) && $item['id'] === $existedFile->document_id) {
                    return true;
                }
                return false;
            });
            if (empty($value)) {
                DB::connection('tbd')
                    ->table($field['table']['name'])
                    ->where('id', $existedFile->id)
                    ->delete();
            }
        }
    }

    protected function prepareDataToSubmit()
    {
        $data = parent::prepareDataToSubmit();
        return array_filter(
            $data,
            function ($key) {
                return !in_array($key, ['gis_method', 'gis_type', 'documents']);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}