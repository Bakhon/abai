<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\ParseJsonException;
use App\Models\BigData\Infrastructure\History;
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

    public function getHistory(int $id, \DateTimeInterface $date): array
    {
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

    public function getFormatedParams(): array
    {
        return [
            'params' => $this->params(),
            'fields' => $this->getFields()->pluck('', 'code')->toArray()
        ];
    }

    public function validateSingleField(string $field): void
    {
        $errors = $this->getCustomValidationErrors();
        $this->validator->validateSingleField(
            $this->request,
            $this->getValidationRules(),
            $this->getValidationAttributeNames(),
            $field,
            $errors
        );
    }

    public function getConfigFilePath()
    {
        return base_path($this->configurationPath) . "/{$this->configurationFileName}.json";
    }

    protected function params(): array
    {
        $jsonFile = $this->getConfigFilePath();
        if (!File::exists($jsonFile)) {
            throw new NotFoundHttpException();
        }
        $params = json_decode(file_get_contents($jsonFile));
        $this->validateParams($params);

        $params = json_decode(json_encode($params), true);
        return $this->localizeParams($params);
    }

    protected function getCustomValidationErrors(): array
    {
        return [];
    }

    private function validate(): void
    {
        $errors = $this->getCustomValidationErrors();
        $this->validator->validate(
            $this->request,
            $this->getValidationRules(),
            $this->getValidationAttributeNames(),
            $errors
        );
    }

    private function getValidationRules(): array
    {
        $rules = [];

        foreach ($this->getFields() as $field) {
            if (empty($field['validation'])) {
                continue;
            }
            $rules[$field['code']] = $field['validation'];
        }

        return $rules;
    }

    private function getValidationAttributeNames(): array
    {
        $attributes = [];

        foreach ($this->getFields() as $field) {
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

    private function validateParams($params)
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
}