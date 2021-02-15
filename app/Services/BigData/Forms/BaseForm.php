<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Http\Request;

abstract class BaseForm
{

    protected $validator;

    public function __construct()
    {
        $this->validator = app()->make(\App\Services\BigData\CustomValidator::class);
    }

    public function send(Request $request): \Illuminate\Database\Eloquent\Model
    {
        $this->validate($request);
        return $this->submit($request);
    }

    private function validate(Request $request): void
    {
        $errors = $this->getCustomValidationErrors($request);
        $this->validator->validate(
            $request,
            $this->getValidationRules(),
            $this->getValidationAttributeNames(),
            $errors
        );
    }

    private function getValidationRules(): array
    {
        $params = $this->params();
        $rules = [];

        foreach ($this->getFields() as $field) {
            $rules[$field['code']] = $field['validation'];
        }

        return $rules;
    }

    abstract protected function params(): array;

    private function getValidationAttributeNames(): array
    {
        $attributes = [];

        foreach ($this->getFields() as $field) {
            $attributes[$field['code']] = $field['title'];
        }

        return $attributes;
    }

    abstract public function submit(Request $request): \Illuminate\Database\Eloquent\Model;

    public function getFormatedParams(): array
    {
        return [
            'params' => $this->params(),
            'fields' => $this->getFields()->pluck('', 'code')->toArray()
        ];
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

    protected function getCustomValidationErrors(Request $request): array
    {
        return [];
    }
}