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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

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
    const POINTS_OR_SEGMENT = 0;

    protected $hydroCalcLongSchema = [
        'distance' => 1,
        'dout' => 2,
        'wt' => 3,
        'liq_rate' => 4,
        'gor' => 5,
        'wc' => 6,
        'pin' => 7,
        'pout' => 8,
        'tin' => 9,
        'tout' => 10,
        'flow_pattern' => 11,
        'vliq' => 12,
        'vgas' => 13,
        'vm' => 14,
        'pressure_gradient' => 15,
        'ohtc' => 16,
        'nre' => 17,
        'holdup' => 18,
        'lambda' => 19,
        'h_soil' => 20,
        'h_f' => 21,
        'npr' => 22,
        'nnu' => 23,
        'f_f_ratio' => 24,
        'rs' => 25,
        'rsw' => 26,
        'ev' => 27,
        'comment' => 28
    ];

    protected $hydroCalcShortSchema = [
        'length' => 3,
        'qliq' => 4,
        'bsw' => 5,
        'gazf' => 6,
        'press_start' => 7,
        'press_end' => 8,
        'temperature_start' => 9,
        'temperature_end' => 10,
        'start_point' => 11,
        'end_point' => 12,
        'mix_speed_avg' => 14,
        'fluid_speed' => 15,
        'gaz_speed' => 16,
        'flow_type' => 17,
        'press_change' => 18,
        'break_qty' => 19,
        'height_drop' => 20
    ];


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

        foreach ($points as $key => $point) {
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

            if (!$points[$key]->omgngdu->pump_discharge_pressure) {
                unset($points[$key]);
                continue;
            }

            if (!$points[$key]->omgngdu->pump_discharge_pressure ||
                !$points[$key]->omgngdu->daily_fluid_production ||
                !$points[$key]->omgngdu->bsw) {
                $isErrors = true;
                break;
            }
        }

        if ($isErrors) {
            if (isset($this->input['cron']) AND $this->input['cron']) {
                Log::channel('calculate_hydro_yesterday:cron')->error('Нет данных по ОМГ НГДУ');
            } else {
                $this->setOutput(
                    [
                        'error' => trans('monitoring.hydro_calculation.error.not-enough-data')
                    ]
                );
            }

            return;
        }

        $data = [
            'points' => $points,
            'columnNames' => $this->columnNames
        ];

        $fileName = 'pipeline_calc_input.xlsx';
        $filePath = 'public/export/' . $fileName;
        Excel::store(new PipeLineCalcExport($data), $filePath);

        if (!$isErrors and isset($this->input['date'])) {

            $fileurl = env('KMG_SERVER_URL') . Storage::url($filePath);
            $url = env('HYDRO_CALC_SERVICE_URL') . 'url_file/?url=' . $fileurl;

            $client = new \GuzzleHttp\Client();

            try {
                $request = $client->post(
                    $url,
                    [
                        'content-type' => 'application/json'
                    ]
                );
            } catch (GuzzleHttp\Exception\ClientException $e) {
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

            if ($short) {
                $this->storeShortResult($short);
            }

            if ($long) {
                array_unshift($long->data, $long->columns);
                $this->storeLongResult($long->data);
            }
        }

        if (isset($this->input['cron']) AND $this->input['cron']) {
            Log::channel('calculate_hydro_yesterday:cron')->info('Расчет на '.$this->input['date'].' успешно завершен.');
        }

        if (isset($this->input['calc_export']) && $this->input['calc_export'] == 'true') {
            $this->setOutput(
                [
                    'filename' => Storage::url($filePath)
                ]
            );
        }
    }

    protected function storeShortResult(array $data): void
    {
        foreach ($data as $row) {
            $trunkline_point = TrunklinePoint::find($row[self::ID]);

            $hydroCalcResult = HydroCalcResult::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $trunkline_point->oil_pipe_id,
                    'trunkline_point_id' => $trunkline_point->id,
                ]
            );

            foreach ($this->hydroCalcShortSchema as $param => $index) {
                $hydroCalcResult->$param = $row[$index];
            }

            $hydroCalcResult->save();
        }
    }

    protected function storeLongResult(array $data): void
    {
        foreach ($data as $row) {
            if (!ctype_digit($row[self::POINTS_OR_SEGMENT])) {
                $pointsNames = explode(' - ', $row[self::POINTS_OR_SEGMENT]);

                $trunkline_point = TrunklinePoint::where('name', $pointsNames[0])
                    ->whereHas('trunkline_end_point', function ($query) use ($pointsNames) {
                        return $query->where('name', $pointsNames[1]);
                    })
                    ->first();

                continue;
            }

            $hydroCalcLong = HydroCalcLong::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $trunkline_point->oil_pipe_id,
                    'segment' => $row[self::POINTS_OR_SEGMENT]
                ]
            );

            foreach ($this->hydroCalcLongSchema as $param => $index) {
                $hydroCalcLong->$param = $row[$index];
            }

            $hydroCalcLong->save();
        }
    }
}
