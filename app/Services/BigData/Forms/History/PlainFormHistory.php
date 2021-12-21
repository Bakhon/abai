<?php


namespace App\Services\BigData\Forms\History;


use App\Models\BigData\Infrastructure\History;
use App\Services\BigData\DictionaryService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PlainFormHistory
{

    public function saveHistory(
        string $formName,
        Collection $formFields,
        ?array $originalData,
        array $submittedData
    ) {
        if (empty($submittedData) || empty($submittedData['id'])) {
            return;
        }

        $payload = [];

        $fields = $this->getFieldsPayload($formFields, $originalData, $submittedData['fields']);

        if (!empty($fields)) {
            $payload['fields'] = $fields;
        }
        if (!empty($submittedData['table_fields'])) {
            $payload['table_fields'] = $submittedData['table_fields'];
        }

        if (!empty($payload)) {
            History::create(
                [
                    'form_name' => $formName,
                    'payload' => $payload,
                    'date' => Carbon::now(),
                    'row_id' => $submittedData['id'],
                    'user_id' => auth()->id(),
                ]
            );
        }
    }

    private function getFieldsPayload(Collection $formFields, ?array $originalData, array $fields)
    {
        $dictService = app()->make(DictionaryService::class);

        $result = [];
        foreach ($fields as $key => $value) {
            if ($formFields->where('code', $key)->isEmpty()) {
                continue;
            }
            $formField = $formFields->where('code', $key)->first();

            $oldValue = $originalData[$key] ?? '';

            if ($value && $formField['type'] === 'dict') {
                $oldValue = !empty($oldValue) ? $dictService->getDictValueById(
                    $formField['dict'],
                    $formField['type'],
                    $oldValue
                ) : '';
                $value = $dictService->getDictValueById($formField['dict'], $formField['type'], $value);
            }

            if ($value && $formField['type'] === 'dict_tree') {
                $oldValue = !empty($oldValue) ? $dictService->getFullPath($formField['dict'], $oldValue) : '';
                $value = $dictService->getFullPath($formField['dict'], $value);
            }

            if ($formField['type'] === 'date') {
                $oldValue = $oldValue ? Carbon::parse($oldValue)->format('d.m.Y') : null;
                $value = $value ? Carbon::parse($value)->format('d.m.Y') : null;
            }

            if ($formField['type'] === 'datetime') {
                $oldValue = $oldValue ? Carbon::parse($oldValue)->format('d.m.Y H:i') : null;
                $value = $value ? Carbon::parse($value)->format('d.m.Y H:i') : null;
            }

            $result[] = [
                'name' => $formField['title'],
                'old' => $oldValue,
                'new' => $value,
                'changed' => $oldValue !== $value
            ];
        }

        return $result;
    }
}