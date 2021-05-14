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

    public function model(array $row)
    {
        if (!isset($row[0]) or ($row[0] == 'org')) {
            return null;
        }

        $source_name = 'EXCEL 2020 ДБиЭИ';

        $sc_fa = EcoRefsScFa::where('name', '=', $source_name)->first();
        $company = EcoRefsCompaniesId::where('name', '=', $row[0])->first();

        return new CostYear([
            "sc_fa" => $sc_fa -> id,
            "company_id" => $company -> id,
            "date" => $row[2],
            "variable" => round($row[56], 5),
            "fix_noWRpayroll" => round($row[57], 5),
            "fix_payroll" => round($row[58], 5),
            "fix_nopayroll" => round($row[59], 5),
            "fix" => round($row[60], 5),
            "gaoverheads" => round($row[61], 5),
            "wr_nopayroll" => round($row[62], 5),
            "wr_payroll" => round($row[63], 5),
            "wo" => round($row[65], 5)
        ]);
    }
}
