<?php

namespace App\Imports;

use App\Models\OtherObjects;
use Maatwebsite\Excel\Concerns\ToModel;

class OtherObjectsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new OtherObjects([
            'name'     => $row[0],
        ]);
    }
}
