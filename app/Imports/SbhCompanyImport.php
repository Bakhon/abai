<?php

namespace App\Imports;

use App\Models\EconomyKenzhe\SbhCompany;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class SbhCompanyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return new SbhCompany([
        //     'num' => $row[0],
        //     'title' => $row[1],
        // ]);
    }
}
