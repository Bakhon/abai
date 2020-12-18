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
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
            "__time" => (\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]))->getTimestamp()*1000,
            'main_prc_val_plan' => $row[2],
            'spending_val_plan' => $row[3],
            'cost_val_plan' => $row[4],
            'rlz_spending_val_plan' => $row[5],
            'adm_spending_val_plan' => $row[6],
            'net_profit_val_plan' => $row[7],
            'editba_val_plan' => $row[8],
            'editba_margin_val_plan' => $row[9],
            'capital_inv_val_plan' => $row[10],
            'cash_flow_val_plan' => $row[11],
            'ud_income_val_plan' => $row[12],
            'ud_income_bbl_val_plan' => $row[13],
            'ud_spending_val_plan' => $row[14],
            'ud_spending_bbl_val_plan' => $row[15],
            'kvl_val_plan' => $row[16],
            'oil_val_plan' => $row[17],
            'main_prc_val_fact' => $row[18],
            'spending_val_fact' => $row[19],
            'cost_val_fact' => $row[20],
            'rlz_spending_val_fact' => $row[21],
            'adm_spending_val_fact' => $row[22],
            'net_profit_val_fact' => $row[23],
            'editba_val_fact' => $row[24],
            'editba_margin_val_fact' => $row[25],
            'capital_inv_val_fact' => $row[26],
            'cash_flow_val_fact' => $row[27],
            'ud_income_val_fact' => $row[28],
            'ud_income_bbl_val_fact' => $row[29],
            'ud_spending_val_fact' => $row[30],
            'ud_spending_bbl_val_fact' => $row[31],
            'kvl_val_fact' => $row[32],
            'oil_val_fact' => $row[33],
            'main_prc_plan_2020' => $row[34],
            'spending_plan_2020' => $row[35],
            'cost_plan_2020' => $row[36],
            'rlz_spending_plan_2020' => $row[37],
            'adm_spending_plan_2020' => $row[38],
            'net_profit_plan_2020' => $row[39],
            'editba_plan_2020' => $row[40],
            'editba_margin_plan_2020' => $row[41],
            'capital_inv_plan_2020' => $row[42],
            'cash_flow_plan_2020' => $row[43],
            'ud_income_plan_2020' => $row[44],
            'ud_income_bbl_plan_2020' => $row[45],
            'ud_spending_plan_2020' => $row[46],
            'ud_spending_bbl_plan_2020' => $row[47],
            'kvl_plan_2020' => $row[48],
            'oil_plan_2020' => $row[49],
            'oil_price_plan_2020' => $row[50],
            'kurs_plan_2020' => $row[51],
            'oil_price_plan' => $row[52],
            'oil_price_fact' => $row[53],
            'kurs_plan' => $row[54],
            'kurs_fact' => $row[55]
        ]);
    }
}
