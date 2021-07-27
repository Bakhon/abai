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

    const COLUMN_WELL_ID = 0;
    const COLUMN_DATE = 1;
    const COLUMN_OIL = 2;
    const COLUMN_LIQUID = 3;
    const COLUMN_DAYS_WORDED = 4;
    const COLUMN_PRS = 5;
    const COLUMN_COMPANY_ID = 6;
    const COLUMN_FIELD_ID = 7;
    const COLUMN_NGDU_ID = 8;
    const COLUMN_GU_ID = 9;
    const COLUMN_CDNG_ID = 10;

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
        if (!isset($row[self::COLUMN_WELL_ID]) || $row[self::COLUMN_WELL_ID] === 'Скважина') {
            return null;
        }

        return new TechnicalDataForecast([
            "source_id" => $this->sourceId,
            "author_id" => $this->userId,
            "log_id" => $this->logId,
            "gu_id" => $this->getGuId($row),
            "well_id" => $row[self::COLUMN_WELL_ID],
            "date" => Date::excelToDateTimeObject($row[self::COLUMN_DATE]),
            "oil" => round($row[self::COLUMN_OIL], 2),
            "liquid" => round($row[self::COLUMN_LIQUID], 2),
            "days_worked" => round($row[self::COLUMN_DAYS_WORDED], 2),
            "prs" => $row[self::COLUMN_PRS],
        ]);
    }

    private function getGuId(array $row): int
    {
        $name = $row[self::COLUMN_GU_ID];

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
        $name = $row[self::COLUMN_CDNG_ID];

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
        $name = $row[self::COLUMN_NGDU_ID];

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
        $name = $row[self::COLUMN_FIELD_ID];

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
        $name = $row[self::COLUMN_COMPANY_ID];

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
