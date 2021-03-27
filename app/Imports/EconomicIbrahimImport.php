<?php

namespace App\Imports;

use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EcoRefsScFa;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureCompany;
use App\Models\Refs\TechnicalStructureField;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureNgdu;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\TechnicalStructureSource;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EconomicIbrahimImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $user_id;
    protected $log_id;

    function __construct($user_id) {
        $this->user_id = $user_id;
        $this->log_id = EconomicDataLog::create(['author_id' => $user_id]);
    }



    public function model(array $row)
    {
        if (!isset($row[0]) or ($row[0] == "org")) {
            return null;
        }

        $sc_fa_name = $row[0];
        $sc_fa = EcoRefsScFa::where('name', '=', $sc_fa_name)->first();
        if (empty($sc_fa)) {
            $sc_fa = EcoRefsScFa::create(["name" => $sc_fa_name]);
        }
        $company = EcoRefsCompaniesId::where('name', '=', $row[1])->first();

        return new EcoRefsCost([
            "sc_fa" => $sc_fa->id,
            "company_id" => $company->id,
            "date" => $row[3],
            "variable" => round($row[4], 2),
            "fix_noWRpayroll" => round($row[5], 2),
            "fix_payroll" => round($row[6], 2),
            "fix_nopayroll" => round($row[7], 2),
            "fix" => round($row[8], 2),
            "gaoverheads" => round($row[9], 2),
            "wr_nopayroll" => round($row[10], 2),
            "wr_payroll" => round($row[11], 2),
            "wo" => round($row[12], 2),
            "author_id" => $this->user_id,
            "log_id" => $this->log_id->id
        ]);
    }
}
