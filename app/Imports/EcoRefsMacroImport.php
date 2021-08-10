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
        'date' => 0,
        'ex_rate_dol' => 1,
        'ex_rate_rub' => 2,
        'inf_end' => 3,
        'barrel_world_price' => 4
    ];

    function __construct(string $fileName)
    {
        $this->scFaId = EcoRefsScFa::firstOrCreate([
            'name' => $fileName,
        ])->id;
    }

    public function model(array $row): ?EcoRefsMacro
    {
        if (!isset($row[self::COLUMNS['date']]) || ($row[self::COLUMNS['date']] === 'Дата:')) {
            return null;
        }
        
        return new EcoRefsMacro([
            "sc_fa" => $this->scFaId,
            "date" => gmdate("Y-m-d", (($row[self::COLUMNS['date']]- 25569) * 86400)),
            "ex_rate_dol" => round($row[self::COLUMNS['ex_rate_dol']], 2),
            "ex_rate_rub" => round($row[self::COLUMNS['ex_rate_rub']], 2),
            "inf_end" => round($row[self::COLUMNS['inf_end']], 2),
            "barrel_world_price" => round($row[self::COLUMNS['barrel_world_price']], 2),
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
