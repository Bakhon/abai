<?php

namespace App\Imports;

use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EcoRefsScFa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EconomicIbrahimImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $userId;

    protected $logId;

    protected $scFaId;

    protected $companies = [];

    const CHUNK = 1000;

    const ORG_COLUMN = 'org';

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
        if (!isset($row[0]) or ($row[0] == self::ORG_COLUMN)) {
            return null;
        }

        $companyName = $row[1];

        $companyId = $this->companies[$companyName]
            ?? EcoRefsCompaniesId::query()
                ->whereName($companyName)
                ->firstOrFail()
                ->id;

        $this->companies[$companyName] = $companyId;

        return new EcoRefsCost([
            "sc_fa" => $this->scFaId,
            "company_id" => $companyId,
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
            "amort" => isset($round[13]) ? round($row[13], 2) : null,
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
}
