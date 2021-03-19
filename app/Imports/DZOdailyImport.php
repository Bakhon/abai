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
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[ 0 ]),
            '__time' => $row[1],
            'dzo' => $row[2],
            'oil_plan' => $row[3],
            'oil_opek_plan' => $row[4],
            'oil_fact' => $row[5],
            'oil_dlv_plan' => $row[6],
            'oil_dlv_opek_plan' => $row[7],
            'oil_dlv_fact' => $row[8],
            'tovarnyi_ostatok_nefti_today' => $row[9],
            'gas_plan' => $row[10],
            'gas_fact' => $row[11],
            'dobycha_gaza_prirod_plan' => $row[12],
            'dobycha_gaza_prirod_fact' => $row[13],
            'sdacha_gaza_prirod_plan' => $row[14],
            'sdacha_gaza_prirod_fact' => $row[15],
            'dobycha_gaza_poput_plan' => $row[16],
            'dobycha_gaza_poput_fact' => $row[17],
            'sdacha_gaza_poput_plan' => $row[18],
            'sdacha_gaza_poput_fact' => $row[19],
            'raskhod_poput_plan' => $row[20],
            'raskhod_poput_fact' => $row[21],
            'pererabotka_gaza_poput_plan' => $row[22],
            'pererabotka_gaza_poput_fact' => $row[23],
            'liq_plan' => $row[24],
            'liq_fact' => $row[25],
            'ppd_zakachka_morskoi_vody_plan' => $row[26],
            'ppd_zakachka_morskoi_vody_fact' => $row[27],
            'ppd_zakachka_stochnoi_vody_plan' => $row[28],
            'ppd_zakachka_stochnoi_vody_fact' => $row[29],
            'ppd_zakachka_albsen_vody_plan' => $row[30],
            'ppd_zakachka_albsen_vody_fact' => $row[31],
            'cpp_zakachka_para_plan' => $row[32],
            'cpp_zakachka_para_fact' => $row[33],
            'prod_wells_work' => $row[34],
            'prod_wells_idle' => $row[35],
            'inj_wells_work' => $row[36],
            'inj_wells_idle' => $row[37],
            'gk_plan' => $row[38],
            'gk_fact' => $row[39],
            'otm_iz_burenia_skv_plan' => $row[40],
            'otm_iz_burenia_skv_fact' => $row[41],
            'otm_burenie_prohodka_plan' => $row[42],
            'otm_burenie_prohodka_fact' => $row[43],
            'fond_neftedob_ef' => $row[44],
            'fond_neftedob_df' => $row[45],
            'fond_neftedob_bd' => $row[46],
            'fond_neftedob_osvoenie' => $row[47],
            'fond_neftedob_ofls' => $row[48],
            'fond_neftedob_prs' => $row[49],
            'fond_neftedob_oprs' => $row[50],
            'fond_neftedob_krs' => $row[51],
            'fond_neftedob_okrs' => $row[52],
            'fond_neftedob_well_survey' => $row[53],
            'fond_neftedob_nrs' => $row[54],
            'fond_neftedob_others' => $row[55],
            'fond_nagnetat_ef' => $row[56],
            'fond_nagnetat_df' => $row[57],
            'fond_nagnetat_bd' => $row[58],
            'fond_nagnetat_osvoenie' => $row[59],
            'fond_nagnetat_ofls' => $row[60],
            'fond_nagnetat_konv' => $row[61],
            'fond_nagnetat_prs' => $row[62],
            'fond_nagnetat_oprs' => $row[63],
            'fond_nagnetat_krs' => $row[64],
            'fond_nagnetat_okrs' => $row[65],
            'fond_nagnetat_well_survey' => $row[66],
            'fond_nagnetat_others' => $row[67],
            'tb_covid_recover' => $row[68],
            'tb_covid_total' => $row[69],
        ]);
    }
}
