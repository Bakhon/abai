<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Facades\DB;

class DailyDrill extends PlainForm
{
    protected $configurationFileName = 'daily_drill';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('kern_sole'))) {
            $errors['kern_sole'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('date_drill'),
            'dict.well',
            'drill_start_date'
        )) {
            $errors['date_drill'][] = trans('bd.validation.drill_date');
        }

        return $errors;
    }

    public function getFormParamsToEdit(array $params)
    {
        $row = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('id', $params['id'])
            ->first();

        return [
            'well_id' => $row->well,
            'values' => $row
        ];
    }
}