<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Services\AttachmentService;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Gis extends PlainForm
{
    protected $configurationFileName = 'gis';
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;

    public function getResults(): array
    {
        try {
            $rows = $this->getRows();

            $columns = $this->getColumns();

            $availableActions = $this->getAvailableActions();
            if ($rows->isNotEmpty()) {
                $availableActions = array_filter($availableActions, function ($action) {
                    return !in_array($action, ['create']);
                });
            }

            return [
                'rows' => $rows->values(),
                'columns' => $columns,
                'form' => $this->params(),
                'available_actions' => array_values($availableActions)
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    protected function getRows(): Collection
    {
        $wellId = (int)$this->request->get('well_id');

        $rows = collect();
        $row = [];

        $lasFiles = $this->getLasFiles($wellId);
        if (!empty($lasFiles)) {
            $row['las'] = $lasFiles;
        }

        $row = array_merge($row, $this->getRowFiles($wellId));

        if (!empty($row)) {
            $row['id'] = $wellId;
            $rows->push($row);
        }

        return $rows;
    }

    private function getLasFiles(int $wellId): ?string
    {
        return DB::connection('tbd')
            ->table('prod.lass_files')
            ->where('well', $wellId)
            ->get()
            ->map(function ($file) {
                return '<a target="_blank" href="' . route('las.download', ['experiment' => $file->exp_id]
                    ) . '">' . $file->name_ru . '</a>';
            })
            ->join('<br>');
    }

    private function getRowFiles(int $wellId): ?array
    {
        $files = DB::connection('tbd')
            ->table('prod.conn_files as f')
            ->select('f.id', 'f.document_id', 'ft.code', 'df.file', 'd.doc_date')
            ->join('prod.document_file as df', 'f.document_id', 'df.document')
            ->join('dict.gis_file_type as ft', 'f.type_connect', 'ft.id')
            ->join('prod.document as d', 'f.document_id', 'd.id')
            ->where('well', $wellId)
            ->get();

        if ($files->isEmpty()) {
            return [];
        }

        $attachmentService = app()->make(AttachmentService::class);
        $filesInfo = $attachmentService->getInfo($files->pluck('file')->toArray());

        return $files->groupBy('code')
            ->map(function ($group) use ($filesInfo) {
                return $group
                    ->map(function ($file) use ($filesInfo) {
                        $fileInfo = $filesInfo->where('id', $file->file)->first();
                        $file->info = $fileInfo;
                        if ($fileInfo) {
                            $file->filename = $file->info->file_name;
                        }
                        return $file;
                    })
                    ->groupBy('document_id')
                    ->map(function ($items) {
                        $text = $items->pluck('filename')->join(', ');
                        return [
                            'id' => $items->first()->document_id,
                            'values' => [
                                'file' => $items,
                                'filenames' => $text,
                                'doc_date' => $items->first()->doc_date
                            ]
                        ];
                    })->values();
            })
            ->toArray();
    }

    protected function getColumns(): Collection
    {
        $columns = collect();
        $columns->push(
            [
                'code' => 'las',
                'form' => 'well_document_short',
                'title' => trans('bd.forms.gis.las_files'),
                'type' => 'table'
            ]
        );

        $columns = $columns->merge(
            $this->getFields()
                ->mapWithKeys(
                    function ($item) {
                        return [$item['code'] => $item];
                    }
                )
        );

        return $columns;
    }

    protected function submitForm(): array
    {
        $this->tableFields = $this->getFields()
            ->filter(
                function ($item) {
                    return $item['type'] === 'table';
                }
            );

        $fileTypes = $this->getFileTypes();

        $this->tableFields
            ->pluck('code')
            ->each(function ($code) use ($fileTypes) {
                $values = $this->request->get($code);

                $this->removeExistedFiles($fileTypes, $code, $values);

                if (empty($values)) {
                    return;
                }

                foreach ($values as $value) {
                    if (is_array($value)) {
                        continue;
                    }
                    DB::connection('tbd')
                        ->table('prod.conn_files')
                        ->insert(
                            [
                                'well' => $this->request->get('well'),
                                'type_connect' => $fileTypes[$code],
                                'document_id' => $value
                            ]
                        );
                }
            });

        return [];
    }

    private function getFileTypes()
    {
        return DB::connection('tbd')
            ->table('dict.gis_file_type')
            ->get()
            ->pluck('id', 'code')
            ->toArray();
    }

    private function removeExistedFiles(array $fileTypes, string $code, array $values = null)
    {
        if ($values === null) {
            return;
        }

        $existedFiles = DB::connection('tbd')
            ->table('prod.conn_files')
            ->where('well', $this->request->get('well'))
            ->where('type_connect', $fileTypes[$code])
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
                    ->table('prod.conn_files')
                    ->where('id', $existedFile->id)
                    ->delete();
            }
        }
    }

    public function delete(int $rowId)
    {
        DB::connection('tbd')
            ->table('prod.conn_files')
            ->where('well', $rowId)
            ->delete();

        DB::connection('tbd')
            ->table('prod.lass_files')
            ->where('well', $rowId)
            ->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}