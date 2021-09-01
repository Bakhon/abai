<?php

namespace App\Imports;

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
        'prv_prod_fact' => 44
    ];

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
            'org_name' => $row[self::COLUMNS['org_name']],
            'org_name_short' => $row[self::COLUMNS['org_name_short']],
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[self::COLUMNS['date']]),
            'oil_prod_plan' => $row[self::COLUMNS['oil_prod_plan']],
            'oil_prod_fact' => $row[self::COLUMNS['oil_prod_fact']],
            'base_oil_prod_plan' => $row[self::COLUMNS['base_oil_prod_plan']],
            'base_oil_prod_fact' => $row[self::COLUMNS['base_oil_prod_fact']],
            'gtm_oil_prod_plan' => $row[self::COLUMNS['gtm_oil_prod_plan']],
            'gtm_oil_prod_fact' => $row[self::COLUMNS['gtm_oil_prod_fact']],
            'vns_plan_total' => $row[self::COLUMNS['vns_plan_total']],
            'vns_fact_total' => $row[self::COLUMNS['vns_fact_total']],
            'vns_prod_plan_total' => $row[self::COLUMNS['vns_prod_plan_total']],
            'vns_prod_fact_total' => $row[self::COLUMNS['vns_prod_fact_total']],
            'vns_plan' => $row[self::COLUMNS['vns_plan']],
            'vns_fact' => $row[self::COLUMNS['vns_fact']],
            'vns_prod_plan' => $row[self::COLUMNS['vns_prod_plan']],
            'vns_prod_fact' => $row[self::COLUMNS['vns_prod_fact']],
            'vns_grp_plan' => $row[self::COLUMNS['vns_grp_plan']],
            'vns_grp_fact' => $row[self::COLUMNS['vns_grp_fact']],
            'vns_grp_prod_plan' => $row[self::COLUMNS['vns_grp_prod_plan']],
            'vns_grp_prod_fact' => $row[self::COLUMNS['vns_grp_prod_fact']],
            'gs_plan' => $row[self::COLUMNS['gs_plan']],
            'gs_fact' => $row[self::COLUMNS['gs_fact']],
            'gs_prod_plan' => $row[self::COLUMNS['gs_prod_plan']],
            'gs_prod_fact' => $row[self::COLUMNS['gs_prod_fact']],
            'zbs_plan' => $row[self::COLUMNS['zbs_plan']],
            'zbs_fact' => $row[self::COLUMNS['zbs_fact']],
            'zbs_prod_plan' => $row[self::COLUMNS['zbs_prod_plan']],
            'zbs_prod_fact' => $row[self::COLUMNS['zbs_prod_fact']],
            'zbgs_plan' => $row[self::COLUMNS['zbgs_plan']],
            'zbgs_fact' => $row[self::COLUMNS['zbgs_fact']],
            'zbgs_prod_plan' => $row[self::COLUMNS['zbgs_prod_plan']],
            'zbgs_prod_fact' => $row[self::COLUMNS['zbgs_prod_fact']],
            'grp_plan' => $row[self::COLUMNS['grp_plan']],
            'grp_fact' => $row[self::COLUMNS['grp_fact']],
            'grp_prod_plan' => $row[self::COLUMNS['grp_prod_plan']],
            'grp_prod_fact' => $row[self::COLUMNS['grp_prod_fact']],
            'pvlg_plan' => $row[self::COLUMNS['pvlg_plan']],
            'pvlg_fact' => $row[self::COLUMNS['pvlg_fact']],
            'pvlg_prod_plan' => $row[self::COLUMNS['pvlg_prod_plan']],
            'pvlg_prod_fact' => $row[self::COLUMNS['pvlg_prod_fact']],
            'pvr_plan' => $row[self::COLUMNS['pvr_plan']],
            'pvr_fact' => $row[self::COLUMNS['pvr_fact']],
            'pvr_prod_plan' => $row[self::COLUMNS['pvr_prod_plan']],
            'prv_prod_fact' => $row[self::COLUMNS['prv_prod_fact']]
        ]);
    }
}
