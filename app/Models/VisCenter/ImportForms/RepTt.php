<?php

namespace App\Models\VisCenter\ImportForms;

use Illuminate\Database\Eloquent\Model;

class RepTt extends Model
{
    //
    protected $fillable = [
        'parent_id',
        'num',
        'title'
    ];

    protected $table = 'rep_tt';

    public function repts(){
        return $this->hasMany(RepTt::class, 'parent_id')->with('childRepts');
    }

    public function childRepts(){
        return $this->hasMany(RepTt::class, 'parent_id')->with('repts');
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