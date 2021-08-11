<?php

namespace App\Imports;

use App\Models\Paegtm\DzoAegtm;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class PaegtmDzoAegtmImport implements ToModel, WithStartRow
{

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function transformDate($value, $format = 'd.m.Y')
    {
        if (empty($value)) {
            return null;
        }
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }

    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new DzoAegtm([
            'org_name' => $row[0],
            'org_name_short' => $row[1],
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'oil_prod_plan' => $row[3],
            'oil_prod_fact' => $row[4],
            'base_oil_prod_plan' => $row[5],
            'base_oil_prod_fact' => $row[6],
            'gtm_oil_prod_plan' => $row[7],
            'gtm_oil_prod_fact' => $row[8],
            'vns_plan_total' => $row[9],
            'vns_fact_total' => $row[10],
            'vns_prod_plan_total' => $row[11],
            'vns_prod_fact_total' => $row[12],
            'vns_plan' => $row[13],
            'vns_fact' => $row[14],
            'vns_prod_plan' => $row[15],
            'vns_prod_fact' => $row[16],
            'vns_grp_plan' => $row[17],
            'vns_grp_fact' => $row[18],
            'vns_grp_prod_plan' => $row[19],
            'vns_grp_prod_fact' => $row[20],
            'gs_plan' => $row[21],
            'gs_fact' => $row[22],
            'gs_prod_plan' => $row[23],
            'gs_prod_fact' => $row[24],
            'zbs_plan' => $row[25],
            'zbs_fact' => $row[26],
            'zbs_prod_plan' => $row[27],
            'zbs_prod_fact' => $row[28],
            'zbgs_plan' => $row[29],
            'zbgs_fact' => $row[30],
            'zbgs_prod_plan' => $row[31],
            'zbgs_prod_fact' => $row[32],
            'grp_plan' => $row[33],
            'grp_fact' => $row[34],
            'grp_prod_plan' => $row[35],
            'grp_prod_fact' => $row[36],
            'pvlg_plan' => $row[37],
            'pvlg_fact' => $row[38],
            'pvlg_prod_plan' => $row[39],
            'pvlg_prod_fact' => $row[40],
            'pvr_plan' => $row[41],
            'pvr_fact' => $row[42],
            'pvr_prod_plan' => $row[43],
            'prv_prod_fact' => $row[44]
        ]);
    }
}
