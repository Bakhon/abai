<?php

namespace App\Imports\Economic;

use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsGtm;
use App\Models\Refs\EcoRefsGtmValue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EconomicGtmValueImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $userId;

    protected $logId;

    protected $companies = [];

    protected $gtms = [];

    const CHUNK = 1000;

    const COLUMNS = [
        'company' => 0,
        'date' => 1,
        'gtm' => 2,
        'priority' => 3,
        'growth' => 4,
        'amount' => 5,
        'comment' => 6,
    ];

    function __construct(int $userId, string $fileName)
    {
        $this->userId = $userId;

        $this->logId = EconomicDataLog::create([
            'author_id' => $userId,
            'name' => $fileName,
            'type_id' => EconomicDataLogType::GTM_VALUE,
        ])->id;
    }

    public function model(array $row): ?EcoRefsGtmValue
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

        $gtmName = $row[self::COLUMNS['gtm']];

        $gtmId = $this->gtms[$gtmName]
            ?? EcoRefsGtm::query()
                ->where([
                    'company_id' => $companyId,
                    'name' => $gtmName
                ])
                ->firstOrFail()
                ->id;

        $this->gtms[$gtmName] = $gtmId;

        return new EcoRefsGtmValue([
            'gtm_id' => $gtmId,
            'date' => Date::excelToDateTimeObject($row[self::COLUMNS['date']]),
            'priority' => $row[self::COLUMNS['priority']],
            'growth' => $row[self::COLUMNS['growth']],
            'amount' => $row[self::COLUMNS['amount']],
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
