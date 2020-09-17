<?php

namespace App\Imports;

use App\Models\Cdng;
use App\Models\Gu;
use App\Models\HydrocarbonOxidizingBacteria;
use App\Models\Ngdu;
use App\Models\OtherObjects;
use App\Models\SulphateReducingBacteria;
use App\Models\ThionicBacteria;
use App\Models\WaterMeasurement;
use App\Models\WaterTypeBySulin;
use App\Models\Well;
use App\Models\Zu;
use Maatwebsite\Excel\Concerns\ToModel;

class WaterMeasurementsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $otherObject = OtherObjects::where('name', '=', $row[0])->first();
        $ngdu = Ngdu::where('name','=',$row[1])->first();
        $cdng = Cdng::where('name','=',$row[2])->first();
        $gu = Gu::where('name','=',$row[3])->first();
        $zu = Zu::where('name','=',$row[4])->first();
        $well = Well::where('name','=',$row[5])->first();
        $waterTypeBySulin = WaterTypeBySulin::where('name','=',$row[19])->first();
        $sulphateReducingBacteria = SulphateReducingBacteria::where('name','=',$row[30])->first();
        $hydrocarbonOxidizingBacteria = HydrocarbonOxidizingBacteria::where('name','=',$row[31])->first();
        $thionicBacteria = ThionicBacteria::where('name','=',$row[32])->first();

        return new WaterMeasurement([
            'other_objects_id' => ($otherObject) ? $otherObject->id : NULL,
            'ngdu_id' => ($ngdu) ? $ngdu->id : NULL,
            'cdng_id' => ($cdng) ? $cdng->id : NULL,
            'gu_id' => ($gu) ? $gu->id : NULL,
            'zu_id' => ($zu) ? $zu->id : NULL,
            'well_id' => ($well) ? $well->id : NULL,
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]),
            'hydrocarbonate_ion' => $row[8],
            'carbonate_ion' => $row[9],
            'sulphate_ion' => $row[10],
            'chlorum_ion' => $row[11],
            'calcium_ion' => $row[12],
            'magnesium_ion' => $row[13],
            'potassium_ion_sodium_ion' => $row[14],
            'density' => $row[15],
            'ph' => $row[16],
            'mineralization' => $row[17],
            'total_hardness' => $row[18],
            'water_type_by_sulin_id' => ($waterTypeBySulin) ? $waterTypeBySulin->id : NULL,
            'content_of_petrolium_products' => $row[20],
            'mechanical_impurities' => $row[21],
            'strontium_content' => $row[22],
            'barium_content' => $row[23],
            'total_iron_content' => $row[24],
            'ferric_iron_content' => $row[25],
            'ferrous_iron_content' => $row[26],
            'hydrogen_sulfide' => $row[27],
            'oxygen' => $row[28],
            'carbon_dioxide' => $row[29],
            'sulphate_reducing_bacteria_id' => ($sulphateReducingBacteria) ? $sulphateReducingBacteria->id : NULL,
            'hydrocarbon_oxidizing_bacteria_id' => ($hydrocarbonOxidizingBacteria) ? $hydrocarbonOxidizingBacteria->id : NULL,
            'thionic_bacteria_id' => ($thionicBacteria) ? $thionicBacteria->id : NULL
        ]);
    }
}
