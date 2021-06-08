<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use Maatwebsite\Excel\Concerns\ToModel;

class WellsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $zu = Zu::where('name', '=', $row[1])->first();
        return new Well([
            'name' => $row[0],
            'zu_id' => $zu->id,
        ]);
    }
}
