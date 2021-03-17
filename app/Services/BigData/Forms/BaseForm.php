<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Http\Resources\BigData\HistoryResource;
use App\Models\BigData\Infrastructure\History;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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

    public function getHistory(int $id, \DateTimeInterface $date): JsonResource
    {
        $history = History::query()
            ->where('row_id', $id)
            ->where('date', $date)
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->get();

        return HistoryResource::collection($history);
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

    protected function params(): array
    {
        $jsonFile = base_path($this->configurationPath) . "/{$this->configurationFileName}.json";
        if (!File::exists($jsonFile)) {
            throw new NotFoundHttpException();
        }
        $params = json_decode(file_get_contents($jsonFile), true);

        return $this->localizeParams($params);
    }

    protected function getCustomValidationErrors(): array
    {
        return [];
    }

    protected function getFields(): \Illuminate\Support\Collection
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
}