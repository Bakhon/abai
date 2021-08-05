<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Facades\DB;

class BottomHole extends PlainForm
{
    protected $configurationFileName = 'bottom_hole';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);

        $bottomHole = DB::connection('tbd')
            ->table('dict.bottom_hole_type')
            ->where('code', 'TD')
            ->first();

        $data['bottom_hole_type'] = $bottomHole->id;
        return $data;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('data'),
            'dict.well',
            'drill_start_date'
        )) {
            $errors['data'][] = trans('bd.validation.bottom_hole_date');
        }

        return $errors;
    }

}