<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;

class ApiController extends MainController
{
    public function companies(){
        return SubholdingCompany::all();
    }

    public function company($id){
        return SubholdingCompany::find($id);
    }

    public function companyValues($id, $dateFrom = null, $dateTo = null){
        $this->companyId = $id;
        if($dateTo and $dateFrom){
            $this->dateTo = $dateTo;
            $this->dateFrom = $dateFrom;
            $currentYear = date('Y', strtotime($this->dateTo));
            $previousYear = (string) $currentYear - 1;
            $handbook = HandbookRepTt::where('parent_id', 0)->with('childHandbookItems')->get()->toArray();
            $companyRepTtValues = SubholdingCompany::find($this->companyId)->statsByDate($currentYear)->get()->toArray();
            return $this->recursiveSetValueToHandbookByType($handbook, $companyRepTtValues, $currentYear, $previousYear, $this->dateFrom, $this->dateTo);
        }

    }
}