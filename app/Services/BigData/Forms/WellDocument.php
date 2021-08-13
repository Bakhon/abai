<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class WellDocument extends PlainForm
{
    protected $configurationFileName = 'well_document';

    public function getResults(int $wellId): JsonResponse
    {
        try {
            $query = DB::connection('tbd')
                ->table('prod.document as d')
                ->join('prod.well_document as wd', 'wd.document', 'd.id')
                ->where('wd.well', $wellId)
                ->orderBy('d.id', 'desc');

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
            $wellId = $data['well'];
            unset($data['well']);

            $dbQuery = DB::connection('tbd')->table($this->params()['table']);

            if (!empty($data['id'])) {
                if (auth()->user()->cannot("bigdata update {$this->configurationFileName}")) {
                    throw new \Exception("You don't have permissions");
                }
                $id = $data['id'];
                unset($data['id']);

                $dbQuery = $dbQuery->where('id', $id);

                $this->originalData = $dbQuery->first();
                $dbQuery->update($data);

                $this->submittedData['fields'] = $data;
                $this->submittedData['id'] = $id;
            } else {
                if (auth()->user()->cannot("bigdata create {$this->configurationFileName}")) {
                    throw new \Exception("You don't have permissions");
                }
                $id = $dbQuery->insertGetId($data);

                $files = $this->request->get('files');
                if (!empty($files['files'])) {
                }
                dd($files);
            }

            $this->insertInnerTable($id);

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }
}