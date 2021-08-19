<?php

namespace App\Traits\BigData\Forms;
use App\Models\BigData\Well;
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

    private function isValidDateDbeg($wellId, $date, $table, $dateType, $rowId = null): bool
    {
        $query = DB::connection('tbd')
            ->table($table)
            ->where('well', $wellId)
            ->where($dateType, '<', Well::DEFAULT_END_DATE)
            ->orderBy($dateType, 'desc');

        if ($rowId) {
            $query->where('id', '!=', $rowId);
        }

        $validDate = $query
            ->get($dateType)
            ->first();
        if (empty($validDate) || $validDate->$dateType == null) {
            return true;
        }
        return $date >= $validDate->$dateType;
    }
   

}