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
    protected $dateValidationField = 'drill_start_date';
    protected $dateValidationErrorKey = 'bd.validation.bottom_hole_date';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getResultsQuery(int $wellId): Collection
    {
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
            $this->dateValidationField
        )) {
            $errors['data'][] = trans($this->dateValidationErrorKey);
        }

        return $errors;
    }

}
