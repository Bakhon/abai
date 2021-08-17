<?php

namespace App\Imports;

use App\Models\Refs\ImportForms\CostYear;
use App\Models\Refs\EcoRefsScFa;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\EcoRefsCompaniesId;

class EcoRefsCostImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    const COLUMNS = [
        'first' => 0,
        'company_id' => 1,
        "date" => 2,
        "variable" => 56,
        "fix_noWRpayroll" =>57,
        "fix_payroll" => 58,
        "fix_nopayroll" => 59,
        "fix" => 60,
        "gaoverheads" => 61,
        "wr_nopayroll" => 62,
        "wr_payroll" => 63,
        "wo" => 65
    ];

    public function model(array $row)
    {
        if (!isset($row[self::COLUMNS['first']]) or ($row[self::COLUMNS['first']] == 'org')) {
            return null;
        }

        $source_name = 'EXCEL 2020 ДБиЭИ';

        $sc_fa = EcoRefsScFa::where('name', '=', $source_name)->first();
        $company = EcoRefsCompaniesId::where('name', '=', $row[self::COLUMNS['first']])->first();

        return new CostYear([
            "sc_fa" => $sc_fa -> id,
            "company_id" => $company -> id,
            "date" => gmdate("Y-m-d", (($row[self::COLUMNS['date']]- 25569) * 86400)),
            "variable" => round($row[self::COLUMNS['variable']], 5),
            "fix_noWRpayroll" => round($row[self::COLUMNS['fix_noWRpayroll']], 5),
            "fix_payroll" => round($row[self::COLUMNS['fix_payroll']], 5),
            "fix_nopayroll" => round($row[self::COLUMNS['fix_nopayroll']], 5),
            "fix" => round($row[self::COLUMNS['fix']], 5),
            "gaoverheads" => round($row[self::COLUMNS['gaoverheads']], 5),
            "wr_nopayroll" => round($row[self::COLUMNS['wr_nopayroll']], 5),
            "wr_payroll" => round($row[self::COLUMNS['wr_payroll']], 5),
            "wo" => round($row[self::COLUMNS['wo']], 5)
        ]);
    }
}
