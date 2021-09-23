<?php

namespace App\Imports\Economic;

use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsGtm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EconomicGtmImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $userId;

    protected $logId;

    protected $companies = [];

    const CHUNK = 1000;

    const COLUMNS = [
        'company' => 0,
        'name' => 1,
        'price' => 2,
        'pi' => 3,
        'comment' => 4,
    ];

    function __construct(int $userId, string $fileName)
    {
        $this->userId = $userId;

        $this->logId = EconomicDataLog::create([
            'author_id' => $userId,
            'name' => $fileName,
            'type_id' => EconomicDataLogType::GTM,
        ])->id;
    }

    public function model(array $row): ?EcoRefsGtm
    {
        if (!isset($row[self::COLUMNS['company']]) || ($row[self::COLUMNS['company']] === 'НДО')) {
            return null;
        }

        $companyName = $row[self::COLUMNS['company']];

        $companyId = $this->companies[$companyName]
            ?? EcoRefsCompaniesId::query()
                ->whereName($companyName)
                ->firstOrFail()
                ->id;

        $this->companies[$companyName] = $companyId;

        return new EcoRefsGtm([
            'company_id' => $companyId,
            'name' => $row[self::COLUMNS['name']],
            'price' => round($row[self::COLUMNS['price']], 2),
            'pi' => round($row[self::COLUMNS['pi']], 2),
            'comment' => $row[self::COLUMNS['comment']],
            'author_id' => $this->userId,
            'log_id' => $this->logId,
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
