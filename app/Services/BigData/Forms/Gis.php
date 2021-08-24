<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Facades\DB;

class Gis extends PlainForm
{
    protected $configurationFileName = 'gis';
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('matering_from'))) {
            $errors['matering_from'][] = trans('bd.validation.depth');
        }
        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('gis_date'),
            'dict.well',
            'drill_start_date'
        )) {
            $errors['gis_date'][] = trans('bd.validation.date');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('process_from'))) {
            $errors['process_from'][] = trans('bd.validation.depth');
        }


        return $errors;
    }

    public function submit(): array
    {
        DB::connection('tbd')->beginTransaction();

        try {
            $this->submitForm();

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }

    private function submitForm()
    {
        $this->tableFields = $this->getFields()
            ->filter(
                function ($item) {
                    return $item['type'] === 'table' && empty($item['form']);
                }
            );

        $this->tableFieldCodes = $this->tableFields
            ->pluck('code')
            ->toArray();

        $data = $this->prepareDataToSubmit();

        unset($data['documents']);
        unset($data['gis_method_type']);

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        if (!empty($data['id'])) {
            $this->checkFormPermission('update');

            $id = $data['id'];
            unset($data['id']);

            $dbQuery = $dbQuery->where('id', $id);

            $this->originalData = $dbQuery->first();
            $dbQuery->update($data);

            $this->submittedData['fields'] = $data;
            $this->submittedData['id'] = $id;
        } else {
            $this->checkFormPermission('create');

            $id = $dbQuery->insertGetId($data);

            $this->insertDocuments($id);
            $this->insertMethodTypes($id);
        }

        $this->insertInnerTable($id);
    }

    private function insertDocuments(int $id)
    {
        if (!empty($this->request->documents)) {
            foreach ($this->request->documents as $documentId) {
                DB::connection('tbd')
                    ->table('prod.gis_file')
                    ->insert(
                        [
                            'file_type' => 4,
                            'document' => $documentId,
                            'gis' => $id
                        ]
                    );
            }
        }
    }

    private function insertMethodTypes(int $id)
    {
        if (!empty($this->request->gis_method_type)) {
            $methods = (array)$this->request->gis_method_type;
            foreach ($methods as $method) {
                DB::connection('tbd')
                    ->table('prod.gis_method_link')
                    ->insert(
                        [
                            'method' => $method,
                            'gis' => $id
                        ]
                    );
            }
        }
    }
}