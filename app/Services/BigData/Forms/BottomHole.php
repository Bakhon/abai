<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BottomHole extends PlainForm
{
    protected $configurationFileName = 'bottom_hole';
    protected $bottomHoleType = 'TD';
    protected $dateValidation = [
        'field' => 'drill_start_date',
        'error_key' => 'bd.validation.bottom_hole_date'
    ];

    use DateMoreThanValidationTrait;
    use DepthValidationTrait;

    protected function getRows(): Collection
    {
        $wellId = $this->request->get('well_id');
        $bottomHole = $this->getBottomHole();

        $query = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('well', $wellId)
            ->where('bottom_hole_type', $bottomHole->id)
            ->orderBy('id', 'desc');

        return $query->get();
    }

    private function getBottomHole(): ?\stdClass
    {
        return DB::connection('tbd')
            ->table('dict.bottom_hole_type')
            ->where('code', $this->bottomHoleType)
            ->first();
    }

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);

        $bottomHole = $this->getBottomHole();

        $data['bottom_hole_type'] = $bottomHole->id;
        return $data;
    }

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDepthofBottomHole($this->request->get('well'), $this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depthBt');
        }

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('data'),
            'dict.well',
            $this->dateValidation['field']
        )) {
            $errors['data'][] = trans($this->dateValidation['error_key']);
        }

        return $errors;
    }

}
