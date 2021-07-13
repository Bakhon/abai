<?php

namespace App\Http\Controllers\Traits;
use Illuminate\Support\Facades\DB;

trait DateValidationTrait
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