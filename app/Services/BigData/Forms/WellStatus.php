<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WellStatus extends PlainForm
{
    protected $configurationFileName = 'well_status';


    private function isValidDate($wellId, $dbeg):bool
    {
            $dend = DB::connection('tbd')
                        ->table('prod.well_status')
                        ->where('well', $wellId)
                        ->orderBy('dend', 'desc')
                        ->get('dend')
                        ->first();
                        

            return $dbeg >= $dend;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate('dbeg')) {
            $errors['dbeg'][] = trans('bd.validation.dbeg');
        }

        return $errors;
    }
    
   

}