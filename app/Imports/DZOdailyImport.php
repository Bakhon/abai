<?php

namespace App\Imports;

use App\Models\VisCenter\ImportForms\DZOdaily;
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
        return new DZOdaily([
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
            "fond_neftedob_ef" => $row[ 19 ],
            "fond_neftedob_df" => $row[ 20 ],
            "fond_neftedob_bd" => $row[ 21 ],
            "fond_neftedob_osvoenie" => $row[ 22 ],
            "fond_neftedob_ofls" => $row[ 23 ],
            "fond_neftedob_prs" => $row[ 24 ],
            "fond_neftedob_oprs" => $row[ 25 ],
            "fond_neftedob_krs" => $row[ 26 ],
            "fond_neftedob_okrs" => $row[ 27 ],
            "fond_neftedob_well_survey" => $row[ 28 ],
            "fond_neftedob_nrs" => $row[ 29 ],
            "fond_neftedob_others" => $row[ 30 ],
            "fond_nagnetat_ef" => $row[ 31 ],
            "fond_nagnetat_df" => $row[ 32 ],
            "fond_nagnetat_bd" => $row[ 33 ],
            "fond_nagnetat_osvoenie" => $row[ 34 ],
            "fond_nagnetat_ofls" => $row[ 35 ],
            "fond_nagnetat_konv" => $row[ 36 ],
            "fond_nagnetat_prs" => $row[ 37 ],
            "fond_nagnetat_oprs" => $row[ 38 ],
            "fond_nagnetat_krs" => $row[ 39 ],
            "fond_nagnetat_okrs" => $row[ 40 ],
            "fond_nagnetat_well_survey" => $row[ 41 ],
            "fond_nagnetat_others" => $row[ 42 ],
            "tb_covid_recover" => $row[ 43 ],
            "tb_covid_total" => $row[ 44 ],
        ]);
    }
}
