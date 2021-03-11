<?php

namespace App\Imports;

use App\Models\EconomyKenzhe\RepTt;
use App\Models\EconomyKenzhe\RepTtValue;
use App\Models\EconomyKenzhe\SbhCompany;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class RepTtValueImport implements ToModel, WithStartRow
{

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        if($row[3] && $row[4] && $row[11]){
            $company = SbhCompany::whereNum($row[4])->first();
            $repTt = RepTt::whereNum($row[3])->first();
            $date = Carbon::createFromFormat('Y.m.d', $row[11].'.01');
            if($company and $repTt){
                return new RepTtValue([
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
