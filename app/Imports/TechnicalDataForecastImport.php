<?php

namespace App\Imports;

use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureCompany;
use App\Models\Refs\TechnicalStructureField;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureNgdu;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalDataLog;
use App\Models\Refs\TechnicalStructureSource;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TechnicalDataForecastImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $user_id;
    protected $log;
    protected $source;

    function __construct($user_id, $file_name) {
        $this->user_id = $user_id;
        $this->log = TechnicalDataLog::create(['author_id' => $user_id]);

        $this->source = TechnicalStructureSource::where('name', '=', $file_name)->first();
        if (empty($this->source)) {
            $this->source = TechnicalStructureSource::create(["name" => $file_name]);
        }
    }


    public function model(array $row)
    {
        if (!isset($row[0]) or ($row[0] == "Скважина")) {
            return null;
        }

        $gu = $this->getGu($this->user_id, $row);

        return new TechnicalDataForecast([
            "source_id" => $this->source->id,
            "gu_id" => $gu->id,
            "well_id" => $row[0],
            "date" => Date::excelToDateTimeObject($row[1]),
            "oil" => round($row[2], 2),
            "liquid" => round($row[3], 2),
            "days_worked" => round($row[4], 2),
            "prs" => $row[5],
            "author_id" => $this->user_id,
            "log_id" => $this->log->id
        ]);
    }

    public function getGu(int $user_id, array $row) {
        $gu_name = $row[9];
        $gu = TechnicalStructureGu::where("name", "=", $gu_name)->first();

        if (empty($gu)) {
            $cdng_name = $row[11];
            $cdng = $this->getCdng($cdng_name, $row, $user_id);

            $gu = TechnicalStructureGu::create([
                "name" => $gu_name,
                "cdng_id" => $cdng -> id,
                "user_id" => $user_id
            ]);
        }
        return $gu;
    }

    /**
     * @param $company_name
     * @param int $user_id
     * @return mixed
     */
    public function getNdo($company_name, int $user_id)
    {
        $ndo = TechnicalStructureCompany::where("short_name", "=", $company_name)->first();
        if (!$ndo) {
            $ndo = TechnicalStructureCompany::create([
                "name" => $company_name,
                "short_name" => $company_name,
                "user_id" => $user_id
            ]);
        }
        return $ndo;
    }

    /**
     * @param $field_name
     * @param $row
     * @param int $user_id
     * @return mixed
     */
    public function getField($field_name, $company_name, int $user_id)
    {
        $field = TechnicalStructureField::where("name", "=", $field_name)->first();
        if (empty($field)) {
            $ndo = $this->getNdo($company_name, $user_id);

            $field = TechnicalStructureField::create([
                "name" => $field_name,
                "company_id" => $ndo->id,
                "user_id" => $user_id
            ]);
        }
        return $field;
    }

    /**
     * @param $ngdu_name
     * @param array $row
     * @param int $user_id
     * @return mixed
     */
    public function getNgdu($ngdu_name, array $row, int $user_id)
    {
        $ngdu = TechnicalStructureNgdu::where("name", "=", $ngdu_name)->first();
        if (empty($ngdu)) {
            $field_name = $row[7];
            $field = $this->getField($field_name, $row[6], $user_id);

            $ngdu = TechnicalStructureNgdu::create([
                "name" => $ngdu_name,
                "field_id" => $field->id,
                "user_id" => $user_id
            ]);
        }
        return $ngdu;
    }

    /**
     * @param $cdng_name
     * @param array $row
     * @param int $user_id
     * @return mixed
     */
    public function getCdng($cdng_name, array $row, int $user_id)
    {
        $cdng = TechnicalStructureCdng::where("name", "=", $cdng_name)->first();
        if (empty($cdng)) {
            $ngdu_name = $row[8];
            $ngdu = $this->getNgdu($ngdu_name, $row, $user_id);

            $cdng = TechnicalStructureCdng::create([
                "name" => $cdng_name,
                "ngdu_id" => $ngdu->id,
                "user_id" => $user_id
            ]);
        }
        return $cdng;
    }
}