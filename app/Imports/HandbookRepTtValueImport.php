<?php

namespace App\Imports;

use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\HandbookRepTtValue;
use App\Models\EconomyKenzhe\SubholdingCompany;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class HandbookRepTtValueImport implements ToModel, WithStartRow
{

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        if($row[3] && $row[4] && $row[11]){
            $company = SubholdingCompany::whereNum($row[4])->first();
            $repTt = HandbookRepTt::whereNum($row[3])->first();
            $date = Carbon::createFromFormat('Y.m.d', $row[11].'.01');
            if($company and $repTt){
                return new HandbookRepTtValue([
                    'company_id'=> $company->id,
                    'rep_id'=> $repTt->id,
                    'value'=>$row[13],
                    'date'=>$date,
                    'rep_tt'=>$row[3],
                    'company'=>$row[4],
                ]);
            }
        }

    }

    public function startRow(): int
    {
        return 3;
    }
}
