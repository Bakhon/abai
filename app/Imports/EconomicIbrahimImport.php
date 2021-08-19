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

    const COLUMNS = [
        'company' => 0,
        'date' => 1,
        'variable' => 2,
        'variable_processing' => 3,
        'fix_noWRpayroll' => 4,
        'fix_payroll' => 5,
        'fix_nopayroll' => 6,
        'fix' => 7,
        'gaoverheads' => 8,
        'wr_nopayroll' => 9,
        'wr_payroll' => 10,
        'wo' => 11,
        'net_back' => 12,
        'amort' => 13,
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
        if (!isset($row[self::COLUMNS['company']]) || ($row[self::COLUMNS['company']] === 'Компания')) {
            return null;
        }

        $companyName = $row[self::COLUMNS['company']];

        $companyId = $this->companies[$companyName]
            ?? EcoRefsCompaniesId::query()
                ->whereName($companyName)
                ->firstOrFail()
                ->id;

        $this->companies[$companyName] = $companyId;

        return new EcoRefsCost([
            "sc_fa" => $this->scFaId,
            "company_id" => $companyId,
            "date" => gmdate("Y-m-d", (($row[self::COLUMNS['date']]- 25569) * 86400)),
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
}
