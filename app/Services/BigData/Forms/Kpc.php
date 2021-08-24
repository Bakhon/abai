<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
class Kpc extends PlainForm
{
    protected $configurationFileName = 'kpc';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;
    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);

        $kpc = DB::connection('tbd')
            ->table('dict.well_repair_type')
            ->where('code', 'CWO')
            ->first();

        $data['repair_type'] = $kpc->id;
        return $data;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('td'))) {
            $errors['td'] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('hud'))) {
            $errors['hud'] = trans('bd.validation.depth');
        }

        return $errors;
    }
}