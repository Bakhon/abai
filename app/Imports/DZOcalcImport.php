<?php

namespace App\Imports;

use App\Models\DZO\DZOcalc;
use Maatwebsite\Excel\Concerns\ToModel;

class DZOcalcImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DZOcalc([
            'dzo' => $row[0],
            'type' => $row[1],
            'jan_plan_2020' => $row[2],
            'jan_fact_2020' => $row[3],
            'jan_fact_2019' => $row[4],
            'feb_plan_2020' => $row[5],
            'feb_fact_2020' => $row[6],
            'feb_fact_2019' => $row[7],
            'mar_plan_2020' => $row[8],
            'mar_fact_2020' => $row[9],
            'mar_fact_2019' => $row[10],
            'apr_plan_2020' => $row[11],
            'apr_fact_2020' => $row[12],
            'apr_fact_2019' => $row[13],
            'may_plan_2020' => $row[14],
            'may_fact_2020' => $row[15],
            'may_fact_2019' => $row[16],
            'jun_plan_2020' => $row[17],
            'jun_fact_2020' => $row[18],
            'jun_fact_2019' => $row[19],
            'jul_plan_2020' => $row[20],
            'jul_fact_2020' => $row[21],
            'jul_fact_2019' => $row[22],
            'aug_plan_2020' => $row[23],
            'aug_fact_2020' => $row[24],
            'aug_fact_2019' => $row[25],
            'sept_plan_2020' => $row[26],
            'sept_fact_2020' => $row[27],
            'sept_fact_2019' => $row[28],
            'oct_plan_2020' => $row[29],
            'oct_fact_2020' => $row[30],
            'oct_fact_2019' => $row[31],
            'plan_2020' => $row[32]
        ]);
    }
}
