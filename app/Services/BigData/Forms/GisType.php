<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\WithDocumentsUpload;
use App\Traits\BigData\Forms\DepthValidationTrait;
class GisType extends PlainForm
{
    protected $configurationFileName = 'gis_type';
    use DepthValidationTrait;
    use WithDocumentsUpload;

    protected function submitForm(): array
    {
        $result = parent::submitForm();

        $gis = \App\Models\BigData\Gis::find($result['id']);
        $gis->methods()->sync($this->request->get('gis_method'));

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
}