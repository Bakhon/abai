<?php

namespace App\Traits;

use App\Http\Controllers\ComplicationMonitoring\OmgNGDUController;
use App\Http\Controllers\ComplicationMonitoring\WaterMeasurementController;
use App\Http\Controllers\DruidController;
use App\Http\Requests\POSTCaller;
use App\Models\ComplicationMonitoring\AbaiprotZu;
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

    public $multiplier = [
        '107' => 1000,
        '107a' => 1000,
        '107b' => 1,
        '107d' => 0.1,
        '107e' => 0.1,
        '107g' => 1,
        '107v' => 0.1,
        '22' => 1,
        '22a' => 1,
        '22b' => 1,
        '22v' => 0.1,
        '24' => 1,
        '24a' => 1,
        '24b' => 1,
        '24d' => 10,
        '24g' => 1,
        '24v' => 0.1,
    ];

    public $errors = [];

    public function parseOmgNgduWellData($abaiprotZus)
    {
        $averages_p_kol = [];
        foreach ($abaiprotZus as $row) {
            $letterIndex = preg_replace('/[^a-zA-Z]/', '', $row->zuid);
            $number = preg_replace('/[^0-9]/', '', $row->zuid);

            $letter = $letterIndex ? $this->translateLetters[$letterIndex] : '';

            $zuName = 'ЗУ-' . $number . $letter;

            $zu = Zu::where('name', $zuName)->first();

            if (!$zu) {
                $message = 'Не найден Zu ' . $row->zuid . ', ЗУ ' . $zuName;
                $errors[] = $message;

                continue;
            }

            $well = Well::where('otvod', $row->otvod)
                ->where('zu_id', $zu->id)->first();

            if ($well) {
                $gu = Gu::find($well->gu_id);
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $row->__time)->format('Y-m-d');

                if (!isset($averages_p_kol[$row->zuid][$date])) {
                    $averages_p_kol[$row->zuid][$date] = $this->getAverageP_Kol($date, $row->zuid);
                }

                $omgngdu = OmgNGDUWell::firstOrNew([
                    'well_id' => $well->id,
                    'zu_id' => $zu->id,
                    'date' => $date
                ]);

                $omgngdu->daily_fluid_production = $row->debet;
                $omgngdu->daily_water_production = $row->debet * $row->vlazh / 100;
                $omgngdu->daily_oil_production = $row->neft_t;
                $omgngdu->bsw = $row->vlazh;
                $omgngdu->sg_oil = isset($this->guData[$gu->name]) ? $this->guData[$gu->name]['sg_oil'] : 0.85;
                $omgngdu->gas_factor = !$row->neft_t ? 0 : $row->gaz / ($row->neft_t / $omgngdu->sg_oil);
                $omgngdu->temperature_zu = $row->tempn;
                $omgngdu->sg_gas = 0.79;
                $omgngdu->sg_water = 1.046;
                $omgngdu->pressure = $averages_p_kol[$row->zuid][$date];
                $omgngdu->save();

                $this->info('Zu - '.$row->zuid.' otvod - '.$row->otvod.' date - '.$date.' saved');
            }
        }
    }

    public function getAverageP_Kol($date, $zuid)
    {
        $start_day = Carbon::createFromFormat('Y-m-d', $date)->startOfDay()->format('Y-m-d H:i:s');
        $end_day = Carbon::createFromFormat('Y-m-d', $date)->endOfDay()->format('Y-m-d H:i:s');
        $suspect_keys = [];
        $p_kol_for_day = AbaiprotZu::where('__time', '>=', $start_day)
            ->where('__time', '<=', $end_day)
            ->where('zuid', $zuid)
            ->whereNotNull('p_kol')
            ->where('p_kol', '!=', 0)
            ->get()
            ->pluck('p_kol')->toArray();

        if (!count($p_kol_for_day)) {
            return 0;
        }

        $multiplier = isset($this->multiplier[$zuid]) ? $this->multiplier[$zuid] : 1;
        $p_kol_for_day = array_map(function ($value) use ($multiplier) {
            return $value * $multiplier;
        }, $p_kol_for_day );


        //remove out-of-range values
        foreach ($p_kol_for_day as $key => $p_kol) {
            for ($i = $key + 1; $i < count($p_kol_for_day); $i++) {
                if ($p_kol > 2 * $p_kol_for_day[$i] || $p_kol < 0.2 * $p_kol_for_day[$i]) {
                    $suspect_keys[$key] = isset($suspect_keys[$key]) ? $suspect_keys[$key] + 1 : 1;
                    $suspect_keys[$i] = isset($suspect_keys[$i]) ? $suspect_keys[$i] + 1 : 1;
                }
            }
        }

        foreach ($suspect_keys as $key => $value) {
            if ($value >= 3) {
                unset($p_kol_for_day[$key]);
            }
        }

        return array_sum($p_kol_for_day) / count($p_kol_for_day);
    }
}