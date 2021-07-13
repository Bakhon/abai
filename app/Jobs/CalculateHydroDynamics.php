<?php

namespace App\Jobs;

use App\Exports\PipeLineCalcExport;
use App\Imports\HydroCalcResultImport;
use App\Models\ComplicationMonitoring\HydroCalcLong;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\TrunklinePoint;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;

class CalculateHydroDynamics implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Trackable;

    public $tries = 1;

    protected $params;
    protected $input;

    protected $columnNames = [
        '№',
        'out_dia',
        'wall_thick',
        'length',
        'qliq',
        'wc',
        'gazf',
        'press_start',
        'press_end',
        'temp_start',
        'temp_end',
        'start_point',
        'end_point',
        'name',
        'mix_speed_avg',
        'fluid_speed',
        'gaz_speed',
        'flow_type',
        'press_change',
        'break_qty',
        'height_drop'
    ];

    const ID = 0;
    const LENGTH = 3;
    const QLIQ = 4;
    const BSW = 5;
    const GAZF = 6;
    const PRESS_START = 7;
    const PRESS_END = 8;
    const TEMPERATURE_START = 9;
    const TEMPERATURE_END = 10;
    const START_POINT = 11;
    const END_POINT = 12;
    const MIX_SPEED_AVERAGE = 14;
    const FLUID_SPEED = 15;
    const GAS_SPEED = 16;
    const FLOW_TYPE = 17;
    const PRESS_CHANGE = 18;
    const BREAK_QTY = 19;
    const HEIGHT_DROP = 20;

    const POINTS_OR_SEGMENT = 0;
    const DISTANCE = 1;
    const DOUT = 2;
    const WT = 3;
    const LIQ_RATE = 4;
    const GOR = 5;
    const WC = 6;
    const PIN = 7;
    const POUT = 8;
    const TIN = 9;
    const TOUT = 10;
    const FLOW_PATTERNT = 11;
    const VLIQ = 12;
    const VGAS = 13;
    const VM = 14;
    const PRESSURE_GRDIENT = 15;
    const OHTC = 16;
    const NRE = 17;
    const HOLDUP = 18;
    const LAMBDA = 19;
    const H_SOIL = 20;
    const H_F = 21;
    const NPR = 22;
    const NNU = 23;
    const F_F_RATIO = 24;
    const RS = 25;
    const RSW = 26;
    const EV = 27;
    const COMMENT = 28;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $input)
    {
        $this->prepareStatus();
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $points = TrunklinePoint::with('oilPipe.pipeType', 'oilPipe.firstCoords', 'oilPipe.lastCoords', 'gu', 'trunkline_end_point')->get();
        $isErrors = false;

        foreach($points as $key => $point) {
            if (!$points[$key]->gu) {
                continue;
            }

            $query = OmgNGDU::where('gu_id', $points[$key]->gu->id)
                ->orderBy('date', 'desc');

            if (isset($this->input['date'])) {
                $query = $query->where('date', $this->input['date']);
            }

            $points[$key]->omgngdu = $query->orderBy('date', 'desc')->first();

            if (!$points[$key]->omgngdu) {
                $isErrors = true;
                break;
            }

            $temperature = $points[$key]->omgngdu->heater_output_temperature;
            $temperature = $temperature ? ($temperature < 40 ? 50 : $temperature) : 50;
            $points[$key]->omgngdu->heater_output_temperature = $temperature;

            if (!$points[$key]->omgngdu->pump_discharge_pressure ||
                !$points[$key]->omgngdu->daily_fluid_production ||
                !$points[$key]->omgngdu->bsw) {
                $isErrors = true;
                break;
            }
        }

        if ($isErrors) {
            $this->setOutput(
                [
                    'error' => trans('monitoring.hydro_calculation.error.not-enough-data')
                ]
            );
            return;
        }

        $data = [
            'points' => $points,
            'columnNames' => $this->columnNames
        ];

        $fileName = 'pipeline_calc_input.xlsx';
        $filePath = 'public/export/'.$fileName;
        Excel::store(new PipeLineCalcExport($data), $filePath);

        if (!$isErrors AND isset($this->input['date'])) {

            $fileurl = env('KMG_SERVER_URL').Storage::url($filePath);
            $url = env('HYDRO_CALC_SERVICE_URL').'url_file/?url='.$fileurl;

            $client = new \GuzzleHttp\Client();

            try {
                $request = $client->post(
                    $url,
                    [
                        'content-type' => 'application/json'
                    ]
                );
            }
            catch (GuzzleHttp\Exception\ClientException $e) {
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();

                $this->setOutput(
                    [
                        'error' => $responseBodyAsString
                    ]
                );
            }

            $data = json_decode($request->getBody()->getContents());
            $short = $data->short->data;
            $long = $data->long;

            $this->storeShortResult($short);

            if ($long) {
                array_unshift($long->data, $long->columns);
                $this->storeLongResult($long->data);
            }
        }

        if (isset($this->input['calc_export']) && $this->input['calc_export'] == 'true') {
            $this->setOutput(
                [
                    'filename' => Storage::url($filePath)
                ]
            );
        }
    }

    protected function storeShortResult (array $data): void
    {
        foreach ($data as $row) {
            $trunkline_point = TrunklinePoint::find($row[self::ID]);

            $hydroCalcResult = HydroCalcResult::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'trunkline_point_id' => $trunkline_point->id,
                ]
            );

            $hydroCalcResult->length = $row[self::LENGTH];
            $hydroCalcResult->qliq = $row[self::QLIQ];
            $hydroCalcResult->bsw = $row[self::BSW];
            $hydroCalcResult->gazf = $row[self::GAZF];
            $hydroCalcResult->press_start = $row[self::PRESS_START];
            $hydroCalcResult->press_end = $row[self::PRESS_END];
            $hydroCalcResult->temperature_start = $row[self::TEMPERATURE_START];
            $hydroCalcResult->temperature_end = $row[self::TEMPERATURE_END];
            $hydroCalcResult->start_point = $row[self::START_POINT];
            $hydroCalcResult->end_point = $row[self::END_POINT];
            $hydroCalcResult->oil_pipe_id = $trunkline_point->oil_pipe_id;
            $hydroCalcResult->mix_speed_avg = $row[self::MIX_SPEED_AVERAGE];
            $hydroCalcResult->fluid_speed = $row[self::FLUID_SPEED];
            $hydroCalcResult->gaz_speed = $row[self::GAS_SPEED];
            $hydroCalcResult->flow_type = $row[self::FLOW_TYPE];
            $hydroCalcResult->press_change = $row[self::PRESS_CHANGE];
            $hydroCalcResult->break_qty = $row[self::BREAK_QTY];
            $hydroCalcResult->height_drop = $row[self::HEIGHT_DROP];
            $hydroCalcResult->save();
        }
    }

    protected function storeLongResult (array $data): void
    {
        foreach ($data as $row) {
            if (!ctype_digit($row[self::POINTS_OR_SEGMENT])) {
                $pointsNames = explode(' - ', $row[self::POINTS_OR_SEGMENT]);

                $trunkline_point = TrunklinePoint::where('name', $pointsNames[0])
                    ->whereHas('trunkline_end_point', function ($query) use ($pointsNames) {
                        return $query->where('name', $pointsNames[1]);
                    })->first();

                continue;
            }

            $hydroCalcLong = HydroCalcLong::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $trunkline_point->oil_pipe_id,
                    'segment' => $row[self::POINTS_OR_SEGMENT]
                ]
            );

            $hydroCalcLong->distance = $row[self::DISTANCE];
            $hydroCalcLong->dout = $row[self::DOUT];
            $hydroCalcLong->wt = $row[self::WT];
            $hydroCalcLong->liq_rate = $row[self::LIQ_RATE];
            $hydroCalcLong->gor = $row[self::GOR];
            $hydroCalcLong->wc = $row[self::WC];
            $hydroCalcLong->pin = $row[self::PIN];
            $hydroCalcLong->pout = $row[self::POUT];
            $hydroCalcLong->tin = $row[self::TIN];
            $hydroCalcLong->tout = $row[self::TOUT];
            $hydroCalcLong->flow_pattern = $row[self::FLOW_PATTERNT];
            $hydroCalcLong->vliq = $row[self::VLIQ];
            $hydroCalcLong->vgas = $row[self::VGAS];
            $hydroCalcLong->vm = $row[self::VM];
            $hydroCalcLong->pressure_gradient = $row[self::PRESSURE_GRDIENT];
            $hydroCalcLong->ohtc = $row[self::OHTC];
            $hydroCalcLong->nre = $row[self::NRE];
            $hydroCalcLong->holdup = $row[self::HOLDUP];
            $hydroCalcLong->lambda = $row[self::LAMBDA];
            $hydroCalcLong->h_soil = $row[self::H_SOIL];
            $hydroCalcLong->h_f = $row[self::H_F];
            $hydroCalcLong->npr = $row[self::NPR];
            $hydroCalcLong->nnu = $row[self::NNU];
            $hydroCalcLong->f_f_ratio = $row[self::F_F_RATIO];
            $hydroCalcLong->rs = $row[self::RS];
            $hydroCalcLong->rsw = $row[self::RSW];
            $hydroCalcLong->comment = $row[self::COMMENT];
            $hydroCalcLong->save();
        }
    }
}
