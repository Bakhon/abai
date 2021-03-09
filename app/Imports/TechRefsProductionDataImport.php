<?php

namespace App\Imports;

use App\Models\Refs\TechRefsCdng;
use App\Models\Refs\TechRefsCompany;
use App\Models\Refs\TechRefsField;
use App\Models\Refs\TechRefsGu;
use App\Models\Refs\TechRefsNgdu;
use App\Models\Refs\TechRefsProductionData;
use App\Models\Refs\TechRefsSource;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TechRefsProductionDataImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        if (!isset($row[0]) or ($row[0] == "Скважина")) {
            return null;
        }

        $user_id = auth()->id();
        $source = TechRefsSource::where("name", "=", "Импорт Excel")->first();
        $gu = self::get_gu($user_id, $row);

        return new TechRefsProductionData([
            "source_id" => $source->id,
            "gu_id" => $gu->id,
            "well_id" => $row[0],
            "date" => Date::excelToDateTimeObject($row[1]),
            "oil" => round($row[2], 2),
            "liquid" => round($row[3], 2),
            "days_worked" => round($row[4], 2),
            "prs" => $row[5],
            "author_id" => $user_id
        ]);
    }

    public function get_gu(int $user_id, array $row) {
        $gu_name = $row[9];
        $gu = TechRefsGu::where("name", "=", $gu_name)->first();

        if (empty($gu)) {
            $cdng_name = $row[11];
            $cdng = TechRefsCdng::where("name", "=", $cdng_name)->first();
                if (empty($cdng)) {
                $ngdu_name = $row[8];
                $ngdu = TechRefsNgdu::where("name", "=", $ngdu_name)->first();
                if (empty($ngdu)) {
                    $field_name = $row[7];
                    $field = TechRefsField::where("name", "=", $field_name)->first();
                    if (empty($field)) {
                        $company_name = $row[6];
                        $ndo = TechRefsCompany::where("short_name", "=", $company_name)->first();
                        if (!$ndo) {
                            $ndo = TechRefsCompany::create([
                                "name" => $company_name,
                                "short_name" => $company_name,
                                "user_id" => $user_id
                            ]);
                        }

                        $field = TechRefsField::create([
                            "name" => $field_name,
                            "company_id" => $ndo -> id,
                            "user_id" => $user_id
                        ]);
                    }

                    $ngdu = TechRefsNgdu::create([
                        "name" => $ngdu_name,
                        "field_id" => $field -> id,
                        "user_id" => $user_id
                    ]);
                }

                $cdng = TechRefsCdng::create([
                    "name" => $cdng_name,
                    "ngdu_id" => $ngdu -> id,
                    "user_id" => $user_id
                ]);
            }

            $gu = TechRefsGu::create([
                "name" => $gu_name,
                "cdng_id" => $cdng -> id,
                "user_id" => $user_id
            ]);
        }
        return $gu;
    }
}
