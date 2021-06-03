<?php

namespace App\Imports;

use App\Models\Refs\Cdng;
use App\Models\ComplicationMonitoring\Gu;
use Maatwebsite\Excel\Concerns\ToModel;

class GusImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cdng = Cdng::where('name', '=', $row[1])->first();
        return new Gu([
            'name' => $row[0],
            'cdng_id' => $cdng->id,
        ]);
    }
}
