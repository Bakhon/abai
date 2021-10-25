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
        'permanent_year_cost' => 6,
        'avg_prs_cost' => 7,
        'oil_density' => 8,
        'days' => 9,
        'variable_stop_cost_fact' => 10,
        'variable_stop_cost_forecast' => 11,
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
            'netback_plan' => round($row[self::COLUMNS['netback_plan']], 2),
            'netback_fact' => round($row[self::COLUMNS['netback_fact']], 2),
            'netback_forecast' => round($row[self::COLUMNS['netback_forecast']], 2),
            'variable_cost' => round($row[self::COLUMNS['variable_cost']], 2),
            'permanent_cost' => round($row[self::COLUMNS['permanent_cost']], 2),
            'permanent_year_cost' => round($row[self::COLUMNS['permanent_year_cost']], 2),
            'avg_prs_cost' => round($row[self::COLUMNS['avg_prs_cost']], 2),
            'oil_density' => round($row[self::COLUMNS['oil_density']], 2),
            'days' => (int)$row[self::COLUMNS['days']],
            'variable_stop_cost_fact' => round($row[self::COLUMNS['variable_stop_cost_fact']], 2),
            'variable_stop_cost_forecast' => round($row[self::COLUMNS['variable_stop_cost_forecast']], 2),
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
