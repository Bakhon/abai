<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Infrastructure\History;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class TableForm extends BaseForm
{
    abstract public function getRows(array $params = []);

    abstract protected function saveSingleFieldInDB(string $field): void;

    public function saveSingleField(string $field)
    {
        $this->validateSingleField($field);
        $this->saveSingleFieldInDB($field);
        $this->saveHistory($field, $this->request->get($field));

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getFormatedParams(): array
    {
        return [
            'params' => $this->params(),
            'fields' => $this->getFields()->pluck('', 'code')->toArray(),
            'filterTree' => $this->getFilterTree()
        ];
    }

    protected function getFieldByCode(string $code)
    {
        return $this->getFields()->where('code', $code)->first();
    }

    protected function getFilterTree(): array
    {
        return [];
    }

    protected function getFields(): Collection
    {
        return collect($this->params()['columns']);
    }

    private function saveHistory(string $field, $value)
    {
        $history = History::create(
            [
                'form_name' => $this->configurationFileName,
                'payload' => [
                    $field => $value
                ],
                'date' => Carbon::parse($this->request->get('date')),
                'row_id' => $this->request->get('well_id'),
                'user_id' => auth()->id()
            ]
        );
    }

    private function getFieldRow(array $column, int $wellId, string $date)
    {
        return DB::connection('tbd')
            ->table($column['table'])
            ->where('well_id', $wellId)
            ->whereDate(
                'dbeg',
                '=',
                Carbon::parse($date)->toDateTimeString()
            )
            ->first();
    }
}