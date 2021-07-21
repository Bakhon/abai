<?php

namespace App\Traits\BigData\Forms;
use Illuminate\Support\Facades\DB;

trait DateMoreThanValidationTrait
{
    protected function isValidDate($wellId, $date , $table , $dateType): bool
    {
        $validDate =  DB::connection('tbd')
            ->table($table)
            ->where('id', $wellId)
            ->get($dateType)
            ->first();            
        
        if(empty($validDate) || $validDate->$dateType == null){
            return true;
        }
        return $date >= $validDate->$dateType;    
    } 
   
}