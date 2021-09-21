<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use App\Models\BigData\Infrastructure\History;
use App\Models\BigData\Well;
use App\Services\BigData\DictionaryService;
use App\Services\BigData\Forms\History\PlainFormHistory;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class PlainForm extends BaseForm
{
    protected $jsonValidationSchemeFileName = 'plain_form.json';
    protected $tableFields;
    protected $tableFieldCodes;

    protected $formFields;

    protected $originalData;
    protected $submittedData = [];


    public function getFields(): Collection
    {
        if ($this->formFields) {
            return $this->formFields;
        }

        $fields = collect();
        foreach ($this->params()['tabs'] as $tab) {
            foreach ($tab['blocks'] as $block) {
                foreach ($block as $subBlock) {
                    if (empty($subBlock['items'])) {
                        continue;
                    }
                    foreach ($subBlock['items'] as $item) {
                        $fields[] = $item;
                    }
                }
            }
        }

        $this->formFields = $fields;
        return $fields;
    }

    public function send(): array
    {
        $this->validate();
        $result = $this->submit();
        $this->saveHistory();
        return $result;
    }

    public function submit(): array
    {
        DB::connection('tbd')->beginTransaction();

        try {
            $result = $this->submitForm();
            DB::connection('tbd')->commit();
            return $result;
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }

    protected function submitForm(): array
    {
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
        }

        $this->insertInnerTable($id);

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except(array_merge($this->tableFieldCodes, ['files']));

        if (!empty($this->params()['default_values'])) {
            $data = array_merge($this->params()['default_values'], $data);
        }
        if (array_key_exists('dend', $data) && empty($data['dend'])) {
            $data['dend'] = Well::DEFAULT_END_DATE;
        }

        return $data;
    }

    protected function checkFormPermission(string $action)
    {
        if (auth()->user()->cannot("bigdata {$action} {$this->configurationFileName}")) {
            throw new \Exception("You don't have permissions");
        }
    }

    public function getResults(): array
    {
        $rows = $this->getRows();
        $columns = $this->getColumns();

        return [
            'rows' => $rows->values(),
            'columns' => $columns,
            'form' => $this->params()
        ];
    }

    protected function getResultsQuery(int $wellId): Collection
    {
        $query = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('well', $wellId)
            ->orderBy('id', 'desc');

        return $query->get();
    }

    public function getCalculatedFields(int $wellId, array $values): array
    {
        return [];
    }

    public function getUpdatedFields(int $wellId, array $values): array
    {
        return [];
    }

    public function getUpdatedFieldList(int $wellId, array $values): array
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

    public function getHistory(int $id, \DateTimeInterface $date = null): array
    {
        $historyItems = History::query()
            ->where('row_id', $id)
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->get();

        $result = [];

        foreach ($historyItems as $history) {
            foreach ($history->payload as $key => $value) {
                $result[] = [
                    'id' => $history->id,
                    'updated_at' => $history->updated_at,
                    'user' => $history->user->name,
                    'payload' => $value
                ];
            }
        }

        return $result;
    }

    public function getFormatedParams(): array
    {
        $cacheKey = 'bd_forms_' . $this->configurationFileName . '_params';
        if (!config('app.debug') && Cache::has($cacheKey)) {
            $params = Cache::get($cacheKey);
        } else {
            $params = $this->params();
            $params = $this->getFormatedFieldDependencies($params);
            Cache::put($cacheKey, $params, now()->addDay());
        }

        return $params;
    }

    protected function getFormatedFieldDependencies(array $params): array
    {
        if (empty($params['tabs'])) {
            return $params;
        }

        $dictionaryService = app()->make(DictionaryService::class);

        foreach ($params['tabs'] as &$tab) {
            foreach ($tab['blocks'] as &$block) {
                foreach ($block as &$subBlock) {
                    if (empty($subBlock['items'])) {
                        continue;
                    }
                    foreach ($subBlock['items'] as &$item) {
                        if (empty($item['depends_on'])) {
                            continue;
                        }

                        $item['depends_on'] = array_map(function ($dependency) use ($dictionaryService) {
                            if (!is_array($dependency['value'])) {
                                return $dependency;
                            }

                            $referencedField = $this->getFields()
                                ->where('code', $dependency['field'])
                                ->whereIn('type', ['dict', 'dict_tree'])
                                ->first();

                            if (empty($referencedField)) {
                                return [];
                            }

                            $dict = $dictionaryService->get($referencedField['dict']);
                            $code = $dependency['value']['code'];
                            $dictItem = array_filter($dict, function ($item) use ($code) {
                                return !empty($item['code']) && $item['code'] === $code;
                            });

                            if (empty($dictItem)) {
                                return [];
                            }

                            $dependency['value'] = reset($dictItem)['id'];

                            return $dependency;
                        }, $item['depends_on']);
                    }
                }
            }
        }

        return $params;
    }

    protected function insertInnerTable(int $id)
    {
        if (!empty($this->tableFields)) {
            foreach ($this->tableFields as $field) {
                if (!empty($this->request->get($field['code']))) {
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

    protected function formatRows(Collection $rows): Collection
    {
        return $rows->map(function ($row) {
            if (isset($row->dend)) {
                if (Carbon::parse($row->dend) > Carbon::parse('01-01-3000')) {
                    $row->dend = null;
                }
            }
            return $row;
        });
    }

    private function saveHistory()
    {
        $historyService = new PlainFormHistory();
        $historyService->saveHistory(
            $this->configurationFileName,
            $this->getFields(),
            $this->originalData,
            $this->submittedData
        );
    }

    protected function getRows(): Collection
    {
        $wellId = $this->request->get('well_id');
        $query = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('well', $wellId)
            ->orderBy('id', 'desc');

        $rows = $query->get();

        if (!empty($this->params()['sort'])) {
            foreach ($this->params()['sort'] as $sort) {
                if ($sort['order'] === 'desc') {
                    $rows = $rows->sortByDesc($sort['field']);
                } else {
                    $rows = $rows->sortBy($sort['field']);
                }
            }
        }

        return $this->formatRows($rows);
    }

    protected function getColumns(): Collection
    {
        $columns = $this->getFields()->filter(
            function ($item) {
                if (isset($item['depends_on'])) {
                    return false;
                }

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
        return $columns;
    }

}