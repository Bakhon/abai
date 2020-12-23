<?php

namespace App\Imports;

use App\Models\Refs\Gu;
use App\Models\Refs\Zu;
use Maatwebsite\Excel\Concerns\ToModel;

class ZusImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $gu = Gu::where('name', '=', $row[1])->first();
        return new Zu([
            'name' => $row[0],
            'gu_id' => $gu->id,
        ]);
    }
}
