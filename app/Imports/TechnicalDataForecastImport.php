<?php

namespace App\Imports;

use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalDataLog;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureCompany;
use App\Models\Refs\TechnicalStructureField;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureNgdu;
use App\Models\Refs\TechnicalStructureSource;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TechnicalDataForecastImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $userId;

    protected $logId;

    protected $sourceId;

    protected $guIds = [];

    protected $cdngIds = [];

    protected $ngduIds = [];

    protected $fieldIds = [];

    protected $companyIds = [];

    const CHUNK = 1000;

    const WELL_COLUMN = 'Скважина';

    function __construct(int $userId, string $fileName)
    {
        $this->userId = $userId;

        $this->logId = TechnicalDataLog::create([
            'author_id' => $userId
        ])->id;

        $this->sourceId = TechnicalStructureSource::firstOrCreate([
            'name' => $fileName,
        ])->id;
    }

    public function model(array $row): ?TechnicalDataForecast
    {
        if (!isset($row[0]) || $row[0] === self::WELL_COLUMN) {
            return null;
        }

        return new TechnicalDataForecast([
            "source_id" => $this->sourceId,
            "author_id" => $this->userId,
            "log_id" => $this->logId,
            "gu_id" => $this->getGuId($row),
            "well_id" => $row[0],
            "date" => Date::excelToDateTimeObject($row[1]),
            "oil" => round($row[2], 2),
            "liquid" => round($row[3], 2),
            "days_worked" => round($row[4], 2),
            "prs" => $row[5],
        ]);
    }

    private function getGuId(array $row): int
    {
        $name = $row[9];

        if (isset($this->guIds[$name])) {
            return $this->guIds[$name];
        }

        $this->guIds[$name] = TechnicalStructureGu::query()
            ->firstOrCreate(
                ['name' => $name],
                ['user_id' => $this->userId, 'cdng_id' => $this->getCdngId($row)]
            )
            ->id;

        return $this->guIds[$name];
    }

    private function getCdngId(array $row): int
    {
        $name = $row[10];

        if (isset($this->cdngIds[$name])) {
            return $this->cdngIds[$name];
        }

        $this->cdngIds[$name] = TechnicalStructureCdng::query()
            ->firstOrCreate(
                ['name' => $name],
                ['user_id' => $this->userId, 'ngdu_id' => $this->getNgduId($row)]
            )
            ->id;

        return $this->cdngIds[$name];
    }

    private function getNgduId(array $row): int
    {
        $name = $row[8];

        if (isset($this->ngduIds[$name])) {
            return $this->ngduIds[$name];
        }

        $this->ngduIds[$name] = TechnicalStructureNgdu::query()
            ->firstOrCreate(
                ['name' => $name],
                ['user_id' => $this->userId, 'field_id' => $this->getFieldId($row)]
            )
            ->id;

        return $this->ngduIds[$name];
    }

    private function getFieldId(array $row): int
    {
        $name = $row[7];

        if (isset($this->fieldIds[$name])) {
            return $this->fieldIds[$name];
        }

        $this->fieldIds[$name] = TechnicalStructureField::query()
            ->firstOrCreate(
                ['name' => $name],
                ['user_id' => $this->userId, 'company_id' => $this->getCompanyId($row)]
            )
            ->id;

        return $this->fieldIds[$name];
    }

    private function getCompanyId(array $row): int
    {
        $name = $row[6];

        if (isset($this->companyIds[$name])) {
            return $this->companyIds[$name];
        }

        $this->companyIds[$name] = TechnicalStructureCompany::query()
            ->firstOrCreate(
                ['short_name' => $name],
                ['name' => $name, 'user_id' => $this->userId]
            )
            ->id;

        return $this->companyIds[$name];
    }

    public function batchSize(): int
    {
        return self::CHUNK;
    }

    public function chunkSize(): int
    {
        return self::CHUNK;
    }
}
