<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Http\Request;

abstract class BaseForm
{
    public function send(Request $request): \Illuminate\Database\Eloquent\Model
    {
        $this->validate($request);
        return $this->submit($request);
    }

    private function validate(Request $request): void
    {
        $rules = $this->getValidationRules();
        $request->validate($rules, [], $this->getValidationAttributeNames());
    }

    private function getValidationRules(): array
    {
        $params = $this->params();
        $rules = [];

        foreach ($params['tabs'] as $tab) {
            foreach ($tab['blocks'] as $block) {
                foreach ($block['items'] as $item) {
                    $rules[$item['code']] = $item['validation'];
                }
            }
        }

        return $rules;
    }

    abstract protected function params(): array;

    private function getValidationAttributeNames(): array
    {
        $attributes = [];
        $params = $this->params();

        foreach ($params['tabs'] as $tab) {
            foreach ($tab['blocks'] as $block) {
                foreach ($block['items'] as $item) {
                    $attributes[$item['code']] = $item['title'];
                }
            }
        }

        return $attributes;
    }

    abstract public function submit(Request $request): \Illuminate\Database\Eloquent\Model;

    public function getFormatedParams(): array
    {
        $params = $this->params();
        $fieldValues = $this->getFieldValues($params);

        return [
            'params' => $params,
            'formValues' => $fieldValues
        ];
    }

    private function getFieldValues($params): array
    {
        $fields = [];

        foreach ($params['tabs'] as $tab) {
            foreach ($tab['blocks'] as $block) {
                foreach ($block['items'] as $item) {
                    $fields[$item['code']] = '';
                }
            }
        }

        return $fields;
    }
}