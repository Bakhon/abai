<?php

namespace App\Imports;

use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;


class HandbookRepTtTitlesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return HandbookRepTt
     */
    public function model(array $row)
    {
        return new HandbookRepTt([
            'num'=>$row[0],
            'parent_id'=>$row[1],
            'name'=>$row[2],
        ]);
    }

}
