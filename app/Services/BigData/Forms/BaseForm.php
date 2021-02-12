<?php

namespace App\Services\BigData\Forms;

use Illuminate\Http\Request;

abstract class BaseForm
{
    public function send(Request $request)
    {
        $this->validate($request);
        $this->submit($request);
    }

    private function validate(Request $request)
    {
        $rules = $this->prepareValidationRules();
        $request->validate($rules, [], $this->getValidationAttributeNames());
    }

    private function prepareValidationRules()
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

    abstract protected function params();

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

    abstract public function submit(Request $request);

    public function getFormatedParams()
    {
        $params = $this->params();
        $fieldValues = $this->getFieldValues($params);

        return [
            'params' => $params,
            'formValues' => $fieldValues
        ];
    }

    private function getFieldValues($params)
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