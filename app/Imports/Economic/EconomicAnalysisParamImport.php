<?php

namespace App\Imports\Economic;

use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsAnalysisParam;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EconomicAnalysisParamImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $userId;

    protected $logId;

    const CHUNK = 1000;

    const COLUMNS = [
        'date' => 0,
        'netback_plan' => 1,
        'netback_fact' => 2,
        'netback_forecast' => 3,
        'variable_cost' => 4,
        'permanent_cost' => 5,
        'avg_prs_cost' => 6,
        'oil_density' => 7,
        'days' => 8,
        'permanent_year_cost' => 9,
    ];

    function __construct(int $userId, string $fileName)
    {
        $this->userId = $userId;

        $this->logId = EconomicDataLog::firstOrCreate(
            ['name' => $fileName, 'type_id' => EconomicDataLogType::ANALYSIS_PARAM],
            ['author_id' => $userId]
        )->id;
    }

    public function model(array $row): ?EcoRefsAnalysisParam
    {
        if (!isset($row[self::COLUMNS['date']]) || ($row[self::COLUMNS['date']] === 'Месяц')) {
            return null;
        }

        return new EcoRefsAnalysisParam([
            'date' => Date::excelToDateTimeObject($row[self::COLUMNS['date']]),
            'netback_plan' => round($row[self::COLUMNS['netback_plan']], 12),
            'netback_fact' => round($row[self::COLUMNS['netback_fact']], 12),
            'netback_forecast' => round($row[self::COLUMNS['netback_forecast']], 12),
            'variable_cost' => round($row[self::COLUMNS['variable_cost']], 12),
            'permanent_cost' => round($row[self::COLUMNS['permanent_cost']], 12),
            'permanent_year_cost' => round($row[self::COLUMNS['permanent_year_cost']], 12),
            'avg_prs_cost' => round($row[self::COLUMNS['avg_prs_cost']], 12),
            'oil_density' => round($row[self::COLUMNS['oil_density']], 12),
            'days' => (int)$row[self::COLUMNS['days']],
            'user_id' => $this->userId,
            'log_id' => $this->logId
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
