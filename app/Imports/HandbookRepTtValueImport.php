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

    const HANDBOOK_COMPANY_NUM = 5;

    const HANDBOOK_REPTT_NUM = 13;

    const HANDBOOK_DATE = 6;

    const HANDBOOK_TYPE = 15;

    const HANDBOOK_VALUE = 15;

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
        $company = SubholdingCompany::whereNum(trim($row[self::HANDBOOK_NUM]))->first();
        $repTt = HandbookRepTt::whereNum(trim($row[self::HANDBOOK_REPTT_NUM]))->first();
        $date = Carbon::createFromFormat('Y.m.d', $row[HANDBOOK_DATE].'.01')->format('Y-m-d');
        $type = trim($row[self::HANDBOOK_TYPE]);
        $type = $type == 'ACTUAL_Y0' ? 'fact': 'plan';
        if($company and $repTt){
            return new HandbookRepTtValue([
                'company_id'=> $company->id,
                'rep_id'=> $repTt->id,
                'value'=>$row[self::HANDBOOK_VALUE],
                'date'=>$date,
                'type'=>$type,
                'rep_tt'=>$row[self::HANDBOOK_REPTT_NUM],
                'company'=>$row[self::HANDBOOK_COMPANY_NUM],
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
