<?php

namespace App\Traits;

use App\Http\Controllers\ComplicationMonitoring\OmgNGDUController;
use App\Http\Controllers\ComplicationMonitoring\WaterMeasurementController;
use App\Http\Controllers\DruidController;
use App\Http\Requests\POSTCaller;
use App\Models\ComplicationMonitoring\CalculatedCorrosion;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait ParseOmgNgduWellTrait
{
    public $translateLetters = [
        'a' => 'а',
        'b' => 'б',
        'v' => 'в',
        'g' => 'г',
        'd' => 'д',
        'e' => 'е',
        'j' => 'ж'
    ];

    public $guData = [
        'ГУ-107' => [
            'gas' => 106,
            'bsw' => 79,
            'sg_oil' => 0.8450
        ],
        'ГУ-22' => [
            'gas' => 120,
            'bsw' => 86,
            'sg_oil' => 0.8531
        ],
        'ГУ-24' => [
            'gas' => 101,
            'bsw' => 83,
            'sg_oil' => 0.8542
        ],
    ];

    public $errors = [];

    public function parseOmgNgduWellData ($abaiprotZus) {
        foreach ($abaiprotZus as $row) {
            $letter = preg_replace('/[^a-zA-Z]/', '', $row->zuid);
            $number = preg_replace('/[^0-9]/', '', $row->zuid);
            $zuName = 'ЗУ-'.$number.$this->translateLetters[$letter];

            $zu = Zu::where('name', $zuName)->first();

            if (!$zu) {
                $message = 'Не найден Zu ' . $row->zuid . ', ЗУ ' .$zuName;
                $errors[] = $message;

                continue;
            }

            $well = Well::where('otvod', $row->otvod)
                ->where('zu_id', $zu->id)->first();

            if ($well) {
                $gu = Gu::find($well->gu_id);
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $row->__time)->format('Y-m-d');
                $omgngdu = OmgNGDUWell::firstOrNew([
                    'well_id' => $well->id,
                    'zu_id' => $zu->id,
                    'date' => $date
                ]);

                $omgngdu->daily_fluid_production = $row->debet;
                $omgngdu->daily_water_production = $row->debet - $row->neft_t * 0.89;
                $omgngdu->daily_oil_production = $row->neft_t;
                $omgngdu->bsw = $row->vlash;
                $omgngdu->gas_factor = isset($guData[$gu->name]) ? $guData[$gu->name]['gas'] : $row->gaz;
                $omgngdu->temperature_zu = $row->tempn;
                $omgngdu->sg_oil = isset($guData[$gu->name]) ? $guData[$gu->name]['sg_oil'] : 0.86;
                $omgngdu->sg_gas = 0.75;
                $omgngdu->sg_water = 1.03;
                $omgngdu->save();
            }
        }
    }
}