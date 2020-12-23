<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Bactericide;
use App\Models\Refs\OtherObjects;
use Maatwebsite\Excel\Concerns\ToModel;

class BactericideImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $otherObject = OtherObjects::where('name', '=', $row[0])->first();
        return new Bactericide([
            'other_objects_id' => $otherObject->id,
            'start_date_of_injection' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
            'final_date_of_injection' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'shock_injection_bactericide_flowrate' => $row[3],
            'constant_injection_bactericide_flowrate' => $row[4],
        ]);
    }
}
