<?php

namespace App\Imports;

use App\Models\EconomyKenzhe\RepTt;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class RepTtImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new RepTt([
            'num' => $row[0],
            'name' => $row[1],
        ]);
    }
}
