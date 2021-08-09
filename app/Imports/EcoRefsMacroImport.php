<?php

namespace App\Imports;

use App\Models\EcoRefsMacro; 
use App\Models\Refs\EcoRefsScFa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EcoRefsMacroImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $scFaId;

    const CHUNK = 1000;

    const ORG_COLUMN = 'Дата:';

    const COLUMNS = [
        'first' => 0,
        'date' => 1,
        'ex_rate_dol' => 2,
        'ex_rate_rub' => 3,
        'inf_end' => 4,
        'barrel_world_price' => 5
    ];

    function __construct(string $fileName)
    {
        $this->scFaId = EcoRefsScFa::firstOrCreate([
            'name' => $fileName,
        ])->id;
    }

    public function model(array $row): ?EcoRefsMacro
    {
        if (!isset($row[self::COLUMNS['first']]) || ($row[self::COLUMNS['first']] === 'Дата:')) {
            return null;
        }
        
        return new EcoRefsMacro([
            "sc_fa" => $this->scFaId,
            "date" => gmdate("Y-m-d", (($row[0]- 25569) * 86400)),
            "ex_rate_dol" => round($row[1], 2),
            "ex_rate_rub" => round($row[2], 2),
            "inf_end" => round($row[3], 2),
            "barrel_world_price" => round($row[4], 2),
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
