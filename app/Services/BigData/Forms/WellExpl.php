<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WellExpl extends PlainForm
{
    protected $configurationFileName = 'well_expl';


    private function isValidDate($wellId, $dbeg):bool
    {
            $dend = DB::connection('tbd')
                        ->table('prod.well_expl')
                        ->where('well', $wellId)
                        ->orderBy('dend', 'desc')
                        ->get('dend')
                        ->first();
                        

            return $dbeg >= $dend;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'),$this->request->get('dbeg'))){
            $errors['dbeg'] = trans('bd.validation.dbeg');
        }

        return $errors;
    }
    
   

}