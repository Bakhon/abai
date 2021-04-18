<?php

namespace App\Models\EconomyKenzhe;

use Illuminate\Database\Eloquent\Model;

class FieldCalcCompany extends Model
{
    protected $table = 'eco_refs_companies_ids';

    public function companiesByName($names){
        $companies = [];
        foreach ($names as $name){
            $companies[] = $this->whereName($name)->first();
        }
        return $companies;
    }
}