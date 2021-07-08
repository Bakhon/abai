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
            $collection = collect($dend);

            $collection = $collection->skip(1);
            // echo(json_encode($collection));
            // $str = $collection->get('1') . "";
            // echo date_format($dend[1], 'Y-m-d H:i:s');           
            // $array = json_decode(str, true);
            // echo(json_encode($array));
            // $collection = $collection->get(1);             
            echo(json_encode($collection->get(1)) . "\n");        
            echo(json_encode($collection->get('dend')));
            // echo substr($str, 0, 6), "\n";
            return $dbeg >= $dend;
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