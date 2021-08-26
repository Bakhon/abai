<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use App\Services\AttachmentService;
use Carbon\Carbon;
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
                ->select('d.id', 'owner', 'load_date', 'name_ru', 'doc_date', 'doc_type', 'org', 'well', 'file')
                ->join('prod.well_document as wd', 'wd.document', 'd.id')
                ->join('prod.document_file as df', 'df.document', 'd.id')
                ->where('wd.well', $wellId)
                ->orderBy('d.id', 'desc');

            $tmpRows = $query->get();
            $rows = [];
            $fileIds = $tmpRows->pluck('file')->unique()->toArray();
            if (!empty($fileIds)) {
                $files = $this->getFilesInfo($fileIds);

                foreach ($tmpRows as $row) {
                    $file = $files->where('id', $row->file)->first();
                    if (isset($rows[$row->id])) {
                        $rows[$row->id]->file[] = $file;
                    } else {
                        $row->file = [$file];
                        $rows[$row->id] = $row;
                    }
                }
            }

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
                    'rows' => array_values($rows),
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
            $data['owner'] = auth()->id();
            $data['load_date'] = Carbon::now();
            $wellId = $data['well'];
            $files = $data['file'];
            unset($data['well']);
            unset($data['file']);

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

                $existedFiles = DB::connection('tbd')
                    ->table('prod.document_file')
                    ->where('document', $id)
                    ->get()
                    ->map(function ($file) {
                        return $file->file;
                    })
                    ->toArray();

                foreach ($existedFiles as $existedFile) {
                    if (in_array($existedFile, $files)) {
                        continue;
                    }
                    DB::connection('tbd')
                        ->table('prod.document_file')
                        ->where('document', $id)
                        ->where('file', $existedFile)
                        ->delete();
                }

                if (!empty($files)) {
                    foreach ($files as $file) {
                        if (in_array($file, $existedFiles)) {
                            continue;
                        }
                        DB::connection('tbd')
                            ->table('prod.document_file')
                            ->insert(
                                [
                                    'document' => $id,
                                    'file' => $file
                                ]
                            );
                    }
                }
            } else {
                if (auth()->user()->cannot("bigdata create {$this->configurationFileName}")) {
                    throw new \Exception("You don't have permissions");
                }
                $id = $dbQuery->insertGetId($data);

                DB::connection('tbd')
                    ->table('prod.well_document')
                    ->insert(
                        [
                            'document' => $id,
                            'well' => $wellId
                        ]
                    );

                if (!empty($files)) {
                    foreach ($files as $file) {
                        DB::connection('tbd')
                            ->table('prod.document_file')
                            ->insert(
                                [
                                    'document' => $id,
                                    'file' => $file
                                ]
                            );
                    }
                }
            }

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }

    private function getFilesInfo(array $fileIds)
    {
        $attachmentService = app()->make(AttachmentService::class);
        return $attachmentService->getInfo($fileIds);
    }
}