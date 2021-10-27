<?php

namespace App\Imports\Economic\Technical;

use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellLossStatus;
use App\Models\Refs\TechnicalWellStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TechnicalWellForecastImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $userId;

    protected $logId;

    protected $statusIds = [];

    protected $lossStatusIds = [];

    const CHUNK = 1000;

    const COLUMNS = [
        'uwi' => 0,
        'date' => 1,
        'oil' => 2,
        'liquid' => 3,
        'active_hours' => 4,
        'paused_hours' => 5,
        'status' => 6,
        'prs_portion' => 7,
        'loss_status' => 8,
        'oil_forecast' => 9,
        'oil_loss' => 10,
        'liquid_forecast' => 11,
        'liquid_loss' => 12,
        'oil_tech_loss' => 13,
        'liquid_tech_loss' => 14,
    ];

    function __construct(int $userId, string $fileName)
    {
        $this->userId = $userId;

        $this->logId = EconomicDataLog::firstOrCreate(
            ['name' => $fileName, 'type_id' => EconomicDataLogType::WELL_FORECAST],
            ['author_id' => $userId]
        )->id;
    }

    public function model(array $row): ?TechnicalWellForecast
    {
        if (!isset($row[self::COLUMNS['uwi']]) || ($row[self::COLUMNS['uwi']] === 'Скважина')) {
            return null;
        }

        return new TechnicalWellForecast([
            'uwi' => $row[self::COLUMNS['uwi']],
            'date' => Date::excelToDateTimeObject($row[self::COLUMNS['date']]),
            'oil' => round($row[self::COLUMNS['oil']], 2),
            'liquid' => round($row[self::COLUMNS['liquid']], 2),
            'active_hours' => (int)$row[self::COLUMNS['active_hours']],
            'paused_hours' => (int)$row[self::COLUMNS['paused_hours']],
            'prs_portion' => round($row[self::COLUMNS['prs_portion']], 2),
            'oil_forecast' => round($row[self::COLUMNS['oil_forecast']], 2),
            'oil_loss' => round($row[self::COLUMNS['oil_loss']], 2),
            'liquid_forecast' => round($row[self::COLUMNS['liquid_forecast']], 2),
            'liquid_loss' => round($row[self::COLUMNS['liquid_loss']], 2),
            'oil_tech_loss' => round($row[self::COLUMNS['oil_tech_loss']], 2),
            'liquid_tech_loss' => round($row[self::COLUMNS['liquid_tech_loss']], 2),
            'status_id' => $this->getStatusId($row),
            'loss_status_id' => $this->getLossStatusId($row),
            'user_id' => $this->userId,
            'log_id' => $this->logId
        ]);
    }

    private function getStatusId(array $row): ?int
    {
        $name = $row[self::COLUMNS['status']];

        if (!$name) {
            return null;
        }

        if (!isset($this->statusIds[$name])) {
            $this->statusIds[$name] = TechnicalWellStatus::firstOrCreate(
                ['name' => $name],
                ['user_id' => $this->userId],
            )->id;
        }

        return $this->statusIds[$name];
    }

    private function getLossStatusId(array $row): ?int
    {
        $name = $row[self::COLUMNS['loss_status']];

        if (!$name) {
            return null;
        }

        if (!isset($this->lossStatusIds[$name])) {
            $this->lossStatusIds[$name] = TechnicalWellLossStatus::firstOrCreate(
                ['name' => $name],
                ['user_id' => $this->userId],
            )->id;
        }

        return $this->lossStatusIds[$name];
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