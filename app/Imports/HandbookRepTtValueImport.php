<?php

namespace App\Imports;

use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\HandbookRepTtValue;
use App\Models\EconomyKenzhe\SubholdingCompany;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;


class HandbookRepTtValueImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading
{

    protected $importFyleType = 'plan';

    function __construct($importExcelType)
    {
        $this->importFyleType = $importExcelType;
    }

    /**
     * @param array $row
     *
     * @return HandbookRepTtValue
     */
    public function model(array $row)
    {
        $company = SubholdingCompany::whereNum(trim($row[4]))->first();
        $repTt = HandbookRepTt::whereNum(trim($row[3]))->first();
        $date = Carbon::createFromFormat('Y.m.d', $row[11].'.01');
        if($company and $repTt){
            return new HandbookRepTtValue([
                'company_id'=> $company->id,
                'rep_id'=> $repTt->id,
                'value'=>$row[13],
                'date'=>$date,
                'type'=>$this->importFyleType,
                'rep_tt'=>$row[3],
                'company'=>$row[4],
            ]);
        }
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }

    public function startRow(): int
    {
        return 2;
    }

}
