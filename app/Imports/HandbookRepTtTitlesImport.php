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
    protected $importFyleType = 'opiu';

    function __construct($importExcelType)
    {
        $this->importFyleType = $importExcelType;
    }

    /**
     * @param array $row
     *
     * @return HandbookRepTt
     */
    public function model(array $row)
    {
        return new HandbookRepTt([
            'num'=>$row[0],
            'name'=>$row[1],
            'type'=> $this->importFyleType,
        ]);
    }

}
