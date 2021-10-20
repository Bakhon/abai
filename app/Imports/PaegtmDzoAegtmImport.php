<?php

namespace App\Imports;

use App\Models\BigData\Dictionaries\Org;
use App\Models\Paegtm\DzoAegtm;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class PaegtmDzoAegtmImport implements ToModel, WithStartRow
{

    const COLUMNS = [
        'org_name' => 0,
        'org_name_short' => 1,
        'date' => 2,
        'oil_prod_plan' => 3,
        'oil_prod_fact' => 4,
        'base_oil_prod_plan' => 5,
        'base_oil_prod_fact' => 6,
        'gtm_oil_prod_plan' => 7,
        'gtm_oil_prod_fact' => 8,
        'vns_plan_total' => 9,
        'vns_fact_total' => 10,
        'vns_prod_plan_total' => 11,
        'vns_prod_fact_total' => 12,
        'vns_plan' => 13,
        'vns_fact' => 14,
        'vns_prod_plan' => 15,
        'vns_prod_fact' => 16,
        'vns_grp_plan' => 17,
        'vns_grp_fact' => 18,
        'vns_grp_prod_plan' => 19,
        'vns_grp_prod_fact' => 20,
        'gs_plan' => 21,
        'gs_fact' => 22,
        'gs_prod_plan' => 23,
        'gs_prod_fact' => 24,
        'zbs_plan' => 25,
        'zbs_fact' => 26,
        'zbs_prod_plan' => 27,
        'zbs_prod_fact' => 28,
        'zbgs_plan' => 29,
        'zbgs_fact' => 30,
        'zbgs_prod_plan' => 31,
        'zbgs_prod_fact' => 32,
        'grp_plan' => 33,
        'grp_fact' => 34,
        'grp_prod_plan' => 35,
        'grp_prod_fact' => 36,
        'pvlg_plan' => 37,
        'pvlg_fact' => 38,
        'pvlg_prod_plan' => 39,
        'pvlg_prod_fact' => 40,
        'pvr_plan' => 41,
        'pvr_fact' => 42,
        'pvr_prod_plan' => 43,
        'pvr_prod_fact' => 44,
        'gs_grp_plan' => 45,
        'gs_grp_fact' => 46,
        'gs_grp_prod_plan' => 47,
        'gs_grp_prod_fact' => 48,
        'deepening_plan' => 49,
        'deepening_fact' => 50,
        'deepening_prod_plan' => 51,
        'deepening_prod_fact' => 52,
        'grp_skin_plan' => 53,
        'grp_skin_fact' => 54,
        'grp_skin_prod_plan' => 55,
        'grp_skin_prod_fact' => 56,
        'perestrel_plan' => 57,
        'perestrel_fact' => 58,
        'perestrel_prod_plan' => 59,
        'perestrel_prod_fact' => 60,
        'dostrel_plan' => 61,
        'dostrel_fact' => 62,
        'dostrel_prod_plan' => 63,
        'dostrel_prod_fact' => 64,
        'vbd_plan' => 65,
        'vbd_fact' => 66,
        'vbd_prod_plan' => 67,
        'vbd_prod_fact' => 68,
        'opl_plan' => 69,
        'opl_fact' => 70,
        'opl_prod_plan' => 71,
        'opl_prod_fact' => 72,
        'transfer_to_oil_plan' => 73,
        'transfer_to_oil_fact' => 74,
        'transfer_to_oil_prod_plan' => 75,
        'transfer_to_oil_prod_fact' => 76,
        'uecn_plan' => 77,
        'uecn_fact' => 78,
        'uecn_prod_plan' => 79,
        'uecn_prod_fact' => 80,
        'pvlg_pri_prs_plan' => 81,
        'pvlg_pri_prs_fact' => 82,
        'pvlg_pri_prs_prod_plan' => 83,
        'pvlg_pri_prs_prod_fact' => 84,
        'vpp_plan' => 85,
        'vpp_fact' => 86,
        'vpp_prod_plan' => 87,
        'vpp_prod_fact' => 88,
        'pfp_plan' => 89,
        'pfp_fact' => 90,
        'pfp_prod_plan' => 91,
        'pfp_prod_fact' => 92,
        'tgrp_plan' => 93,
        'tgrp_fact' => 94,
        'tgrp_prod_plan' => 95,
        'tgrp_prod_fact' => 96,
        'vns_oper_plan' => 97,
        'vns_oper_fact' => 98,
        'vns_oper_prod_plan' => 99,
        'vns_oper_prod_fact' => 100,
        'vns_nn_plan' => 101,
        'vns_nn_fact' => 102,
        'vns_nn_prod_plan' => 103,
        'vns_nn_prod_fact' => 104,
        'vns_nn_oper_plan' => 105,
        'vns_nn_oper_fact' => 106,
        'vns_nn_oper_prod_plan' => 107,
        'vns_nn_oper_prod_fact' => 108,
        'idn_plan' => 109,
        'idn_fact' => 110,
        'idn_prod_plan' => 111,
        'idn_prod_fact' => 112,

        'vns_prod_plan_chart'  => 113,
        'vns_prod_fact_chart'  => 114,
        'vns_plan_chart'  => 115,
        'vns_fact_chart'  => 116,
        'gtm_prod_plan_chart'  => 117,
        'gtm_prod_fact_chart'  => 118,
        'gtm_plan_chart'  => 119,
        'gtm_fact_chart'  => 120,
    ];

    private $_orgs;

    public function __construct()
    {
        $this->_orgs = Org::all();
    }

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
        $arFileds = [];

        $org = $this->_orgs->where('name_short_ru', $row[self::COLUMNS['org_name_short']])->first();

        foreach (self::COLUMNS as $field => $columnIndex) {
            if ($field == 'date') {
                $arFileds[$field] = $this->transformDate($row[$columnIndex]);
                continue;
            }

            $arFileds[$field] =  $row[$columnIndex];
        }

        $arFileds['org_id'] = $org ? $org->id : null;

        return new DzoAegtm($arFileds);
    }
}
