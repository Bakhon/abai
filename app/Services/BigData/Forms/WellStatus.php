<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;

class WellStatus extends PlainForm
{
    protected $configurationFileName = 'well_status';


    private function isValidDate($wellId, $dbeg):bool
    {
            
            $dend = DB::connection('tbd')
                        ->table('prod.well_status')
                        ->where('well', $wellId)
                        ->orderBy('dend', 'desc')
                        ->get('dend');
            $dend = $dend->skip(1);
            $data = $dend->get(1);
           
            return $dbeg >= $data->dend;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'),$this->request->get('dbeg'))){
            $errors[$this->request->get('dbeg')][] = trans('bd.validation.dbeg');
        }

        return $errors;
    }
    
   

}