<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Facades\DB;

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
       
        if($this->request->get('gtm_type')){
            DB::connection('tbd')
                ->table('prod.gtm')
                ->insert(
                    [
                            'well' => $this->request->get('well'),
                            'dbeg' => $this->request->get('dbeg'),
                            'dend' => $this->request->get('dend'),
                            'gtm_type' => $this->request->get('gtm_type'),
                            'company' => $this->request->get('contractor')
                    ]
            );
        }
        
       
        DB::commit();

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }
}