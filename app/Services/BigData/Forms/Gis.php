<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Services\AttachmentService;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Gis extends PlainForm
{
    protected $configurationFileName = 'gis';
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;

    public function getResults(): array
    {
        $wellId = $this->request->get('well_id');
        try {
            $rows = $this->getRows($wellId);

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
                        $file->info = $filesInfo->where('id', $file->file)->first();
                        $file->filename = $file->info->filename;
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

    protected function getCustomValidationErrors(string $field = null): array
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
                if (empty($values)) {
                    return;
                }
                foreach ($values as $value) {
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
}