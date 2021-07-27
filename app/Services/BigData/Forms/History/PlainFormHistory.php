<?php


namespace App\Services\BigData\Forms\History;


use App\Models\BigData\Infrastructure\History;
use Carbon\Carbon;

class PlainFormHistory
{

    public function saveHistory(string $formName, \stdClass $originalData, array $submittedData)
    {
        if (empty($submittedData)) {
            return;
        }

        $payload = [];
        $fields = $this->getFieldsPayload($originalData, $submittedData['fields']);
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

    private function getFieldsPayload(\stdClass $originalData, array $fields)
    {
        $result = [];
        foreach ($fields as $key => $value) {
            $result[] = [
                'name' => $key,
                'old' => $originalData->$key ?? '',
                'new' => $value,
                'changed' => isset($originalData->$key) && $originalData->$key !== $value
            ];
        }
        return $result;
    }
}