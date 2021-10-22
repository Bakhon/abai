<?php

namespace App\Imports\Economic;

use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsWellForecast;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EconomicWellForecastImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $userId;

    protected $logId;

    const CHUNK = 1000;

    const COLUMNS = [
        'uwi' => 0,
        'date' => 1,
        'oil' => 2,
        'liquid' => 3,
        'active_days' => 4,
        'paused_days' => 5,
        'prs_portion' => 6,
        'oil_forecast' => 7,
        'oil_loss' => 8,
        'liquid_forecast' => 9,
        'liquid_loss' => 10,
        'oil_tech_loss' => 11,
        'liquid_tech_loss' => 12,
    ];

    function __construct(int $userId, string $fileName)
    {
        $this->userId = $userId;

        $this->logId = EconomicDataLog::create([
            'author_id' => $userId,
            'name' => $fileName,
            'type_id' => EconomicDataLogType::WELL_FORECAST
        ])->id;
    }

    public function model(array $row): ?EcoRefsWellForecast
    {
        if (!isset($row[self::COLUMNS['uwi']]) || ($row[self::COLUMNS['uwi']] === 'Скважина')) {
            return null;
        }

        return new EcoRefsWellForecast([
            'uwi' => $row[self::COLUMNS['uwi']],
            'date' => Date::excelToDateTimeObject($row[self::COLUMNS['date']]),
            'oil' => round($row[self::COLUMNS['oil']], 2),
            'liquid' => round($row[self::COLUMNS['liquid']], 2),
            'active_days' => (int)$row[self::COLUMNS['active_days']],
            'paused_days' => (int)$row[self::COLUMNS['paused_days']],
            'prs_portion' => round($row[self::COLUMNS['prs_portion']], 2),
            'oil_forecast' => round($row[self::COLUMNS['oil_forecast']], 2),
            'oil_loss' => round($row[self::COLUMNS['oil_loss']], 2),
            'liquid_forecast' => round($row[self::COLUMNS['liquid_forecast']], 2),
            'liquid_loss' => round($row[self::COLUMNS['liquid_loss']], 2),
            'oil_tech_loss' => round($row[self::COLUMNS['oil_tech_loss']], 2),
            'liquid_tech_loss' => round($row[self::COLUMNS['liquid_tech_loss']], 2),
            'author_id' => $this->userId,
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
