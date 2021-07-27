<?php

namespace App\Traits\BigData\Forms;
use Illuminate\Support\Facades\DB;
use App\Models\BigData\Well;

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

    private function isValidDateDbeg($wellId, $date, $table,$dateType ):bool
    {
        $validDate = DB::connection('tbd')
            ->table($table)
            ->where('well', $wellId)
            ->where($dateType, '<', Well::DEFAULT_END_DATE)
            ->orderBy($dateType, 'desc')
            ->get($dateType)
            ->first();        
        if(empty($validDate) || $validDate->$dateType == null){
            return true;
        }
        return $date >= $validDate->$dateType;
    }
   

}