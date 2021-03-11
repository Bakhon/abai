<?php

namespace App\Models\EconomyKenzhe;

use Illuminate\Database\Eloquent\Model;

class SubholdingCompany extends Model
{
    protected $fillable = [
        'num',
        'name'
    ];

    protected $table = 'subholding_companies';

    public function child()
    {
        return $this->hasMany(SubholdingCompany::class, 'parent_id')->with('child_companies');
    }

    public function child_companies()
    {
        return $this->hasMany(SubholdingCompany::class, 'parent_id')->with('child');
    }

    public function stats()
    {
        return $this->hasMany(RepTtValue::class, 'company_id');
    }

    public function statsByDate($date = '')
    {
        return $this->hasMany(RepTtValue::class, 'company_id')->where('date', '=', $date);
    }

    public function toArray()
    {
        $array = parent::toArray();
        $camelArray = array();
        foreach ($array as $name => $value) {
            if ($name == 'child_companies') {
                $camelArray['companies'] = $value;
            } else {
                $camelArray[$name] = $value;
            }

        }
        return $camelArray;
    }

}
