<?php

namespace App\Imports;

use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsRoutesId;
use App\Models\Refs\ImportForms\TarifyTns;
use App\Models\Refs\EcoRefsScFa;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\EcoRefsCompaniesId;

class EcoRefsTarifyTnsAAImport implements ToModel
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
        $direction_name  = 'ЭКСПОРТ';
        $route_name = 'Атасу-Алашанькоу';

        $sc_fa = EcoRefsScFa::where('name', '=', $source_name)->first();
        $company = EcoRefsCompaniesId::where('name', '=', $row[0])->first();
        $direction = EcoRefsDirectionId::where('name', '=', $direction_name)->first();
        $route = EcoRefsRoutesId::where('name', '=', $route_name)->first();

        return new TarifyTns([
            "sc_fa" => $sc_fa -> id,
            "branch_id" => 0,
            "company_id" => $company -> id,
            "direction_id" => $direction -> id,
            "route_id" => $route -> id,
            "exc_id" => 0,
            "route_tn_id" => 0,
            "date" => $row[2],
            "tn_rate" => round($row[46], 2),
        ]);
    }
}
