<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Cdng;
use App\Models\ComplicationMonitoring\Ngdu;
use Maatwebsite\Excel\Concerns\ToModel;

class CdngsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $ngdu = Ngdu::where('name', '=', $row[1])->first();
        return new Cdng([
            'name' => $row[0],
            'ngdu_id' => $ngdu->id,
        ]);
    }
}
