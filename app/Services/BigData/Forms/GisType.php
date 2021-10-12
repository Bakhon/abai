<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Gis;
use App\Traits\BigData\Forms\DepthValidationTrait;
use App\Traits\BigData\Forms\WithDocumentsUpload;
use Illuminate\Support\Collection;

class GisType extends PlainForm
{
    protected $configurationFileName = 'gis_type';
    use DepthValidationTrait;
    use WithDocumentsUpload;

    protected function submitForm(): array
    {
        $result = parent::submitForm();

        $gis = Gis::find($result['id']);
        $gis->methods()->sync($this->request->get('gis_method'));
        $gis->kinds()->sync($this->request->get('gis_kind'));

        return $result;
    }

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('income_devices'))) {
            $errors['income_devices'][] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('zp_top'))) {
            $errors['zp_top'][] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('in_top'))) {
            $errors['in_top'][] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('pm_top'))) {
            $errors['pm_top'][] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('ip_top'))) {
            $errors['ip_top'][] = trans('bd.validation.depth');
        }

        return $errors;
    }

    protected function getRows(): Collection
    {
        $rows = parent::getRows();

        if (!empty($rows)) {
            $rows = $this->addMethodsAndKinds($rows);
            $rows = $this->attachDocuments($rows);
        }

        return $rows;
    }

    private function addMethodsAndKinds(Collection $rows)
    {
        $gises = Gis::where('id', $rows->pluck('id')->toArray())->with('methods', 'kinds')->get();
        return $rows->map(function ($row) use ($gises) {
            $gis = $gises->where('id', $row->id)->first();
            if (!empty($gis)) {
                $row->gis_kind = $gis->kinds->pluck('id')->toArray();
                $row->gis_method = $gis->methods->pluck('id')->toArray();
            }
            return $row;
        });
    }

    protected function prepareDataToSubmit()
    {
        $data = parent::prepareDataToSubmit();
        return array_filter(
            $data,
            function ($key) {
                return !in_array($key, ['gis_method', 'gis_kind', 'documents']);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}