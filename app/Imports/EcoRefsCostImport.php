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

        print $row[2];
        try {
            print $row[56];
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }



        return new CostYear([
            "sc_fa" => $sc_fa -> id,
            "company_id" => $company -> id,
            "date" => $row[2],
            "variable" => round($row[56], 2),
            "fix_noWRpayroll" => round($row[57], 2),
            "fix_payroll" => round($row[58], 2),
            "fix_nopayroll" => round($row[59], 2),
            "fix" => round($row[60], 2),
            "gaoverheads" => round($row[61], 2),
            "wr_nopayroll" => round($row[62], 2),
            "wr_payroll" => round($row[63], 2),
            "wo" => round($row[65], 2)
        ]);
    }
}
