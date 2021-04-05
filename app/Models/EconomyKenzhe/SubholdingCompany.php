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

    public function subCompanies()
    {
        return $this->hasMany(SubholdingCompany::class, 'parent_id')->with('childCompanies');
    }

    public function childCompanies()
    {
        return $this->hasMany(SubholdingCompany::class, 'parent_id')->with('subCompanies');
    }

    public function stats()
    {
        return $this->hasMany(HandbookRepTtValue::class, 'company_id');
    }

    public function statsByDate($year)
    {
        return $this->hasMany(HandbookRepTtValue::class, 'company_id')->whereBetween('date', [date('Y-m-d', strtotime(($year-1).'-01-01')), date('Y-m-d', strtotime($year.'-12-01'))]);
    }

    public function toArray()
    {
        $array = parent::toArray();
        $renameArrayKeys = array();
        foreach ($array as $name => $value) {
            if ($name == 'child_companies') {
                $renameArrayKeys['sub_companies'] = $value;
            } else {
                $renameArrayKeys[$name] = $value;
            }
        }
        return $renameArrayKeys;
    }

}
