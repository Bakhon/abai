<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Http\Request;

abstract class BaseForm
{

    protected $request;

    protected $validator;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validator = app()->make(\App\Services\BigData\CustomValidator::class);
    }

    abstract public function submit(): \Illuminate\Database\Eloquent\Model;

    abstract protected function params(): array;

    public function send(): \Illuminate\Database\Eloquent\Model
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

    private function getFields(): \Illuminate\Support\Collection
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
}