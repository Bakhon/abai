<?php

namespace App\Imports;

use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsRoutesId;
use App\Models\Refs\ImportForms\DiscontCoefBarYear;
use App\Models\Refs\EcoRefsScFa;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\EcoRefsCompaniesId;

class DiscontCoefBarAnpzImport implements ToModel
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
        $direction_name  = 'ВНУТРЕННИЙ РЫНОК';
        $route_name = 'АНПЗ';

        $sc_fa = EcoRefsScFa::where('name', '=', $source_name)->first();
        $company = EcoRefsCompaniesId::where('name', '=', $row[0])->first();
        $direction = EcoRefsDirectionId::where('name', '=', $direction_name)->first();
        $route = EcoRefsRoutesId::where('name', '=', $route_name)->first();

        return new DiscontCoefBarYear([
            "sc_fa" => $sc_fa -> id,
            "company_id" => $company -> id,
            "direction_id" => $direction -> id,
            "route_id" => $route -> id,
            "date" => $row[2],
            "barr_coef" => round($row[9], 2),
            "discont" => round($row[41], 2),
            "macro" => round($row[21], 2),
        ]);
    }
}
