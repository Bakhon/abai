<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseForm
{
    protected $configurationFileName;

    protected $request;

    protected $validator;

    protected $configurationPath = 'resources/params/bd/forms';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validator = app()->make(\App\Services\BigData\CustomValidator::class);
    }

    abstract public function submit(): array;

    protected function params(): array
    {
        $jsonFile = base_path($this->configurationPath) . "/{$this->configurationFileName}.json";
        if (!File::exists($jsonFile)) {
            throw new NotFoundHttpException();
        }
        $params = json_decode(file_get_contents($jsonFile), true);

        return $this->localizeParams($params);
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

    protected function getCustomValidationErrors(): array
    {
        return [];
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

    protected function getFields(): Collection
    {
        $fields = collect();

        foreach ($this->params()['tabs'] as $tab) {
            foreach ($tab['blocks'] as $block) {
                foreach ($block['items'] as $item) {
                    $fields[] = $item;
                }
            }
        }

        return $fields;
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
}