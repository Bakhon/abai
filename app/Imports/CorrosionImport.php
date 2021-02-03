<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\Refs\Cdng;
use App\Models\Refs\Field;
use App\Models\Refs\Gu;
use App\Models\Refs\Ngdu;
use Maatwebsite\Excel\Concerns\ToModel;

class CorrosionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $field = Field::where('name', $row[0])->first();
        $ngdu = Ngdu::where('name','=',$row[1])->first();
        $cdng = Cdng::where('name','=',$row[2])->first();
        $gu = Gu::where('name','=',$row[3])->first();

        return new Corrosion([
            'field_id' => $field->id,
            'ngdu_id' => $ngdu->id,
            'cdng_id' => $cdng->id,
            'gu_id' => $gu->id,
            'start_date_of_background_corrosion' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]),
            'final_date_of_background_corrosion' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]),
            'background_corrosion_velocity' => $row[6],
            'start_date_of_corrosion_velocity_with_inhibitor_measure' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7]),
            'final_date_of_corrosion_velocity_with_inhibitor_measure' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]),
            'corrosion_velocity_with_inhibitor' => $row[9],
        ]);
    }
}
