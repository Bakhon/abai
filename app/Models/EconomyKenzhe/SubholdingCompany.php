<?php

namespace App\Models\EconomyKenzhe;

use Carbon\Carbon;
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

//    public function statsByDate($dateFrom, $dateTo)
    public function statsByDate($date)
    {
//        return $this->hasMany(HandbookRepTtValue::class, 'company_id')->whereBetween('date', [$dateFrom, $dateTo])->orWhereYear('date', '=', Carbon::parse($dateFrom)->subYear()->format('Y'));
        return $this->hasMany(HandbookRepTtValue::class, 'company_id')->whereYear('date', $date)->orWhereYear('date', '=', Carbon::parse($date)->subYear()->format('Y'));
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
