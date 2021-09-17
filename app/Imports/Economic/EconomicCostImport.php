<?php

namespace App\Imports\Economic;

use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EcoRefsScFa;
use App\Models\Refs\TechnicalStructurePes;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EconomicCostImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $userId;

    protected $logId;

    protected $scFaId;

    protected $companyIds = [];

    protected $pesIds = [];

    const CHUNK = 1000;

    const COLUMNS = [
        'company_id' => 0,
        'pes_id' => 1,
        'date' => 2,
        'variable' => 3,
        'variable_processing' => 4,
        'fix_noWRpayroll' => 5,
        'fix_payroll' => 6,
        'fix_nopayroll' => 7,
        'fix' => 8,
        'gaoverheads' => 9,
        'wr_nopayroll' => 10,
        'wr_payroll' => 11,
        'wo' => 12,
        'net_back' => 13,
        'amort' => 14,
    ];

    function __construct(int $userId, string $fileName, bool $isForecast)
    {
        $this->userId = $userId;

        $this->logId = EconomicDataLog::create([
            'author_id' => $userId
        ])->id;

        $this->scFaId = EcoRefsScFa::firstOrCreate([
            'name' => $fileName,
            'is_forecast' => $isForecast
        ])->id;
    }

    public function model(array $row): ?EcoRefsCost
    {
        if (!isset($row[self::COLUMNS['company_id']]) || ($row[self::COLUMNS['company_id']] === 'Компания')) {
            return null;
        }

        return new EcoRefsCost([
            "sc_fa" => $this->scFaId,
            "company_id" => $this->getCompanyId($row),
            "pes_id" => $this->getPesId($row),
            "date" => Date::excelToDateTimeObject($row[self::COLUMNS['date']]),
            "variable" => round($row[self::COLUMNS['variable']], 2),
            "variable_processing" => round($row[self::COLUMNS['variable_processing']], 2),
            "fix_noWRpayroll" => round($row[self::COLUMNS['fix_noWRpayroll']], 2),
            "fix_payroll" => round($row[self::COLUMNS['fix_payroll']], 2),
            "fix_nopayroll" => round($row[self::COLUMNS['fix_nopayroll']], 2),
            "fix" => round($row[self::COLUMNS['fix']], 2),
            "gaoverheads" => round($row[self::COLUMNS['gaoverheads']], 2),
            "wr_nopayroll" => round($row[self::COLUMNS['wr_nopayroll']], 2),
            "wr_payroll" => round($row[self::COLUMNS['wr_payroll']], 2),
            "wo" => round($row[self::COLUMNS['wo']], 2),
            "net_back" => round($row[self::COLUMNS['net_back']], 2),
            "amort" => isset($row[self::COLUMNS['amort']])
                ? round($row[self::COLUMNS['amort']], 2)
                : null,
            "author_id" => $this->userId,
            "log_id" => $this->logId
        ]);
    }

    public function batchSize(): int
    {
        return self::CHUNK;
    }

    public function chunkSize(): int
    {
        return self::CHUNK;
    }

    private function getCompanyId(array $row): int
    {
        $name = $row[self::COLUMNS['company_id']];

        if (isset($this->companyIds[$name])) {
            return $this->companyIds[$name];
        }

        $this->companyIds[$name] = EcoRefsCompaniesId::query()
            ->whereName($name)
            ->firstOrFail()
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
}
