<?php

namespace App\Imports\Economic\Technical;

use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalDataLog;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureCompany;
use App\Models\Refs\TechnicalStructureField;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureNgdu;
use App\Models\Refs\TechnicalStructurePes;
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

    protected $pesIds = [];

    const COLUMNS = [
        'well_id' => 0,
        'pes_id' => 1,
        'date' => 2,
        'oil' => 3,
        'liquid' => 4,
        'days_worked' => 5,
        'prs' => 6,
        'company_id' => 7,
        'field_id' => 8,
        'ngdu_id' => 9,
        'gu_id' => 10,
        'cdng_id' => 11,
    ];

    const CHUNK = 1000;

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
        if (!isset($row[self::COLUMNS['well_id']]) || $row[self::COLUMNS['well_id']] === 'Скважина') {
            return null;
        }

        return new TechnicalDataForecast([
            "source_id" => $this->sourceId,
            "author_id" => $this->userId,
            "log_id" => $this->logId,
            "gu_id" => $this->getGuId($row),
            "well_id" => $row[self::COLUMNS['well_id']],
            "date" => Date::excelToDateTimeObject($row[self::COLUMNS['date']]),
            "oil" => round($row[self::COLUMNS['oil']], 2),
            "liquid" => round($row[self::COLUMNS['liquid']], 2),
            "days_worked" => round($row[self::COLUMNS['days_worked']], 2),
            "prs" => $row[self::COLUMNS['prs']],
            "pes_id" => $this->getPesId($row)
        ]);
    }

    private function getGuId(array $row): int
    {
        $name = $row[self::COLUMNS['gu_id']];

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
        $name = $row[self::COLUMNS['cdng_id']];

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
        $name = $row[self::COLUMNS['ngdu_id']];

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
        $name = $row[self::COLUMNS['field_id']];

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
        $name = $row[self::COLUMNS['company_id']];

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

    private function getPesId(array $row): ?int
    {
        $name = $row[self::COLUMNS['pes_id']];

        if (!$name) {
            return null;
        }

        if (isset($this->pesIds[$name])) {
            return $this->pesIds[$name];
        }

        $this->pesIds[$name] = TechnicalStructurePes::query()
            ->firstOrCreate(
                ['name' => $name],
                ['user_id' => $this->userId]
            )
            ->id;

        return $this->pesIds[$name];
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
