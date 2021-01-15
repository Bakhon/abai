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
            '__time' => $row[1],
            'dzo' => $row[2],
            'oil_plan' => $row[3],
            'oil_fact' => $row[4],
            'oil_dlv_plan' => $row[5],
            'oil_dlv_fact' => $row[6],
            'tovarnyi_ostatok_nefti_today' => $row[7],
            'gas_plan' => $row[8],
            'gas_fact' => $row[9],
            'dobycha_gaza_prirod_plan' => $row[10],
            'dobycha_gaza_prirod_fact' => $row[11],
            'sdacha_gaza_prirod_plan' => $row[12],
            'sdacha_gaza_prirod_fact' => $row[13],
            'dobycha_gaza_poput_plan' => $row[14],
            'dobycha_gaza_poput_fact' => $row[15],
            'sdacha_gaza_poput_plan' => $row[16],
            'sdacha_gaza_poput_fact' => $row[17],
            'raskhod_poput_plan' => $row[18],
            'raskhod_poput_fact' => $row[19],
            'pererabotka_gaza_poput_plan' => $row[20],
            'pererabotka_gaza_poput_fact' => $row[21],
            'liq_plan' => $row[22],
            'liq_fact' => $row[23],
            'ppd_zakachka_morskoi_vody_plan' => $row[24],
            'ppd_zakachka_morskoi_vody_fact' => $row[25],
            'ppd_zakachka_stochnoi_vody_plan' => $row[26],
            'ppd_zakachka_stochnoi_vody_fact' => $row[27],
            'ppd_zakachka_albsen_vody_plan' => $row[28],
            'ppd_zakachka_albsen_vody_fact' => $row[29],
            'cpp_zakachka_para_plan' => $row[30],
            'cpp_zakachka_para_fact' => $row[31],
            'prod_wells_work' => $row[32],
            'prod_wells_idle' => $row[33],
            'inj_wells_work' => $row[34],
            'inj_wells_idle' => $row[35],
            'gk_plan' => $row[36],
            'gk_fact' => $row[37],
            'otm_iz_burenia_skv_plan' => $row[38],
            'otm_iz_burenia_skv_fact' => $row[39],
            'otm_burenie_prohodka_plan' => $row[40],
            'otm_burenie_prohodka_fact' => $row[41],
            'fond_neftedob_ef' => $row[42],
            'fond_neftedob_df' => $row[43],
            'fond_neftedob_bd' => $row[44],
            'fond_neftedob_osvoenie' => $row[45],
            'fond_neftedob_ofls' => $row[46],
            'fond_neftedob_prs' => $row[47],
            'fond_neftedob_oprs' => $row[48],
            'fond_neftedob_krs' => $row[49],
            'fond_neftedob_okrs' => $row[50],
            'fond_neftedob_well_survey' => $row[51],
            'fond_neftedob_nrs' => $row[52],
            'fond_neftedob_others' => $row[53],
            'fond_nagnetat_ef' => $row[54],
            'fond_nagnetat_df' => $row[55],
            'fond_nagnetat_bd' => $row[56],
            'fond_nagnetat_osvoenie' => $row[57],
            'fond_nagnetat_ofls' => $row[58],
            'fond_nagnetat_konv' => $row[59],
            'fond_nagnetat_prs' => $row[60],
            'fond_nagnetat_oprs' => $row[61],
            'fond_nagnetat_krs' => $row[62],
            'fond_nagnetat_okrs' => $row[63],
            'fond_nagnetat_well_survey' => $row[64],
            'fond_nagnetat_others' => $row[65],
            'tb_covid_recover' => $row[66],
            'tb_covid_total' => $row[67],
        ]);
    }
}
