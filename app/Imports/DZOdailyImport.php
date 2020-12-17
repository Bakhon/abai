<?php

namespace App\Imports;

use App\Models\DZO\DZOday;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class DZOdailyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DZOday([
            "date" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[ 0 ]),
            "__time" => $row[ 1 ],
            "dzo" => $row[ 2 ],
            "oil_plan" => $row[ 3 ],
            "oil_fact" => $row[ 4 ],
            "oil_dlv_plan" => $row[ 5 ],
            "oil_dlv_fact" => $row[ 6 ],
            "gas_plan" => $row[ 7 ],
            "gas_fact" => $row[ 8 ],
            "liq_plan" => $row[ 9 ],
            "liq_fact" => $row[ 10 ],
            "prod_wells_work" => $row[ 11 ],
            "prod_wells_idle" => $row[ 12 ],
            "inj_wells_work" => $row[ 13 ],
            "inj_wells_idle" => $row[ 14 ],
            "gk_plan" => $row[ 15 ],
            "gk_fact" => $row[ 16 ],
            "otm_burenie_prohodka_plan" => $row[ 17 ],
            "otm_burenie_prohodka_fact" => $row[ 18 ],
        ]);
    }
}
