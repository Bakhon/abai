<?php

namespace App\Models\VisCenter\ImportForms;

use Illuminate\Database\Eloquent\Model;

class SbhCompany extends Model
{
    //
    protected $fillable = [
        'num',
        'title'
    ];

    protected $table = 'subholding_companies';

    public function repts(){
        return $this->hasMany(SbhCompany::class, 'parent_id')->with('childRepts');
    }

    public function childRepts(){
        return $this->hasMany(SbhCompany::class, 'parent_id')->with('repts');
    }

    public function toArray(){
        $array = parent::toArray();
        $camelArray = array();
        foreach($array as $name => $value){
            if ($name == 'child_repts'){
                $camelArray['repts'] = $value;
            }else{
                $camelArray[$name] = $value;
            }
               
        }
        return $camelArray;
    }

}
