<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;

class Kpc extends KrsPrs
{
    protected $configurationFileName = 'kpc';
    protected $repairType = 'CWO';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
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
    protected function submitForm(): array
    {
        $formFields = $this->request->except('by_ourselves');

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        if (!empty($formFields['id'])) {
            $id = $dbQuery->where('id', $formFields['id'])->update($formFields);
        } else {
            $id = $dbQuery->insertGetId($formFields);
        }
        if($this->request->get('gtm_type')){
            DB::connection('tbd')
                ->table('prod.gtm')
                ->insert(
                    [
                            'well' => $this->request->get('well'),
                            'dbeg' => $this->request->get('dbeg'),
                            'dend' => $this->request->get('dend'),
                            'gtm_type' => $this->request->get('gtm_type'),
                            'company' => $this->request->get('contractor'),
                            'well_previous_status_type' => $this->request->get('well_previous_status_type'),
                            'well_previous_category' => $this->request->get('well_previous_category')
                    ]
            );
        }
        
       
        DB::commit();

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }
}