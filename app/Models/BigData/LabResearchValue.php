<?php

namespace App\Models\BigData;

use App\Models\TBDModel;

class LabResearchValue extends TBDModel
{
    protected $table = 'prod.lab_research_value';

    public function Rnas(int $well_id)
    {
       return LabResearchValue::where('prod.lab_research_value.research','=',function ($subquery) use($well_id){
            $subquery->select('prod.lab_research.id')->from('prod.lab_research')->where('prod.lab_research.well','=',$well_id)->orderBy('prod.lab_research.research_date','desc')->limit(1);
        })->where('prod.lab_research_value.param','=',function ($submetric){
            $submetric->select('dict.metric.id')->from('dict.metric')->where('dict.metric.code','=','PSAT');
        })->select('prod.lab_research_value.value_double')->first();
    }
}
