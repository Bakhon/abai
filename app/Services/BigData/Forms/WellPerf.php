<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class WellPerf extends PlainForm
{
    protected $configurationFileName = 'well_perf';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('base'))) {
            $errors['base'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('perf_date'),
            'dict.well',
            'drill_end_date'
        )) {
            $errors['perf_date'][] = trans('bd.validation.perf_date');
        }

        return $errors;
    }

    public function getFormByRow(array $row): array
    {
        $form = 'well_perf_other';
        switch ($row['perf_type']) {
            case 1:
            case 3:
            case 4:
            case 5:
            case 6:
                $form = 'well_perf_shot';
                break;
            case 13:
                $form = 'well_perf_drill_packer';
                break;
            case 12:
                $form = 'well_perf_stab';
                break;
            case 7:
                $form = 'well_perf_bridge_plug';
                break;
        }
        return ['form' => $form];
    }
}