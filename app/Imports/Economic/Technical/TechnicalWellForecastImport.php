<?php

namespace App\Imports\Economic\Technical;

use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\TechnicalWellForecast;
use App\Models\Refs\TechnicalWellLossStatus;
use App\Models\Refs\TechnicalWellStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TechnicalWellForecastImport implements
    ToModel,
    WithBatchInserts,
    WithChunkReading,
    WithEvents,
    ShouldQueue
{
    use Importable, RegistersEventListeners;

    public $timeout = 6000;


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

    function __construct(int $userId, int $logId)
    {
        $this->userId = $userId;

        $this->logId = $logId;
    }

    public function model(array $row): ?TechnicalWellForecast
    {
        if (!isset($row[self::COLUMNS['uwi']]) || ($row[self::COLUMNS['uwi']] === 'Скважина')) {
            return null;
        }

        $date = Date::excelToDateTimeObject($row[self::COLUMNS['date']]);

        return new TechnicalWellForecast([
            'uwi' => $row[self::COLUMNS['uwi']],
            'date' => $date,
            'date_month' => Carbon::parse($date)->setDay(1)->format('Y-m-d'),
            'oil' => round($row[self::COLUMNS['oil']], 12),
            'liquid' => round($row[self::COLUMNS['liquid']], 12),
            'active_hours' => round($row[self::COLUMNS['active_hours']], 12),
            'paused_hours' => round($row[self::COLUMNS['paused_hours']], 12),
            'prs_portion' => round($row[self::COLUMNS['prs_portion']], 12),
            'oil_forecast' => round($row[self::COLUMNS['oil_forecast']], 12),
            'oil_loss' => round($row[self::COLUMNS['oil_loss']], 12),
            'liquid_forecast' => round($row[self::COLUMNS['liquid_forecast']], 12),
            'liquid_loss' => round($row[self::COLUMNS['liquid_loss']], 12),
            'oil_tech_loss' => round($row[self::COLUMNS['oil_tech_loss']], 12),
            'liquid_tech_loss' => round($row[self::COLUMNS['liquid_tech_loss']], 12),
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

    public static function afterImport(AfterImport $event)
    {
        EconomicDataLog::query()
            ->where([
                'id' => $event->getConcernable()->logId,
                'is_processed' => false,
            ])
            ->update([
                'is_processed' => true
            ]);
    }
}
