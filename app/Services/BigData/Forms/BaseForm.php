<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\ParseJsonException;
use App\Models\BigData\Infrastructure\History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseForm
{
    protected $jsonValidationSchemeFileName;

    protected $configurationFileName;

    protected $request;

    protected $validator;

    protected $configurationPath = 'resources/params/bd/forms';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validator = app()->make(\App\Services\BigData\CustomValidator::class);
    }

    abstract public function getResults(): array;

    public function getHistory($id, string $form, \DateTimeInterface $date = null): array
    {
        if (!$date) {
            $date = Carbon::now();
        }

        $historyItems = History::query()
            ->where('row_id', $id)
            ->where('date', $date)
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->get();

        $result = [];

        foreach ($historyItems as $history) {
            foreach ($history->payload as $key => $value) {
                $result[$key][$history->created_at->format('H:i:s')] = [
                    'user' => $history->user->name,
                    'value' => $value
                ];
            }
        }

        return $result;
    }

    public function send(): array
    {
        $this->validate();
        return $this->submit();
    }

    public function getFormInfo(): array
    {
        return [
            'params' => $this->getFormatedParams(),
            'fields' => $this->getFields()->pluck('', 'code')->toArray(),
            'available_actions' => $this->getAvailableActions()
        ];
    }

    public function validateSingleField(string $field): void
    {
        $errors = $this->getCustomValidationErrors($field);
        $this->validator->validateSingleField(
            $this->request,
            $this->getValidationRules(),
            $this->getValidationAttributeNames(),
            $field,
            $errors
        );
    }

    public function validateSingleTableField(string $parent, string $field): void
    {
        $parentField = $this->getFields()->where('code', $parent)->first();
        if (empty($parentField)) {
            return;
        }

        $this->validator->validateSingleField(
            $this->request,
            $this->getValidationRules($parentField['columns']),
            $this->getValidationAttributeNames($parentField['columns']),
            $field
        );
    }

    protected function getFormatedParams(): array
    {
        return $this->params();
    }

    protected function params(): array
    {
        $jsonFile = $this->getConfigFilePath();
        if (!File::exists($jsonFile)) {
            throw new NotFoundHttpException();
        }
        $params = json_decode(file_get_contents($jsonFile));
        $this->validateParams($params);

        $params = $this->filterParams(json_decode(json_encode($params), true));
        return $this->localizeParams($params);
    }

    public function getConfigFilePath()
    {
        return base_path($this->configurationPath) . "/{$this->configurationFileName}.json";
    }

    private function validateParams(\stdClass $params)
    {
        $validator = new \JsonSchema\Validator();
        $schemaFilePath = 'file://' . resource_path('params/bd/forms/schema/') . $this->jsonValidationSchemeFileName;

        $validator->validate($params, (object)['$ref' => $schemaFilePath]);

        if (!$validator->isValid()) {
            foreach ($validator->getErrors() as $error) {
                $errors[] = sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            throw new ParseJsonException(implode('<br>', $errors));
        }
    }

    protected function getCustomValidationErrors(string $field = null): array
    {
        return [];
    }

    protected function getAvailableActions(): array
    {
        $defaultActions = [
            'create',
            'update',
            'view history',
            'delete',
        ];

        $actions = $this->params()['available_actions'] ?? $defaultActions;

        $actions = array_filter(
            $actions,
            function ($action) {
                return auth()->user()->can("bigdata {$action} {$this->configurationFileName}");
            }
        );

        return array_values($actions);
    }

    protected function validate()
    {
        $errors = $this->getCustomValidationErrors();
        $this->validator->validate(
            $this->request,
            $this->getValidationRules(),
            $this->getValidationAttributeNames(),
            $errors
        );
    }

    protected function getValidationRules($fields = []): array
    {
        if (empty($fields)) {
            $fields = $this->getFields();
        }
        $rules = [];

        foreach ($fields as $field) {
            if (empty($field['validation'])) {
                continue;
            }
            $rules[$field['code']] = $field['validation'];
        }

        return $rules;
    }

    protected function getValidationAttributeNames($fields = []): array
    {
        if (empty($fields)) {
            $fields = $this->getFields();
        }
        $attributes = [];

        foreach ($fields as $field) {
            $attributes[$field['code']] = $field['title'];
        }

        return $attributes;
    }

    private function localizeParams(array $params): array
    {
        foreach ($params as $key => &$param) {
            if (is_array($param)) {
                $param = $this->localizeParams($param);
            }
            if ($key === 'title') {
                $transKey = "bd.forms.{$this->configurationFileName}.{$param}";
                if ($transKey !== trans($transKey)) {
                    $param = trans($transKey);
                }
            }
        }
        return $params;
    }

    public function getFormParamsToEdit(array $params)
    {
        return [];
    }
}