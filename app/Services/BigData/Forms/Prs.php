<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class Prs extends PlainForm
{
    protected $configurationFileName = 'prs';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;
    use DepthValidationTrait;
    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);

        $prs = DB::connection('tbd')
            ->table('dict.well_repair_type')
            ->where('code', 'WLO')
            ->first();

        $data['repair_type'] = $prs->id;
        return $data;
    }


    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('actual_bh'))) {
            $errors['actual_bh'] = trans('bd.validation.depth');
        }

        return $errors;
    }
}