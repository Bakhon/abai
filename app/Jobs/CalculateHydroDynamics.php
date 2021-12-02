<?php

namespace App\Jobs;

use App\Exports\PipeLineCalcExport;
use App\Imports\HydroCalcResultImport;
use App\Models\ComplicationMonitoring\HydroCalcLong;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\PipeCoord;
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
        'ID',
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

    const SHORT_ID = 0;
    const LONG_ID = 1;
    const POINTS_OR_SEGMENT = 0;

    protected $hydroCalcLongSchema = [
        'distance' => 2,
        'dout' => 3,
        'wt' => 4,
        'liq_rate' => 5,
        'gor' => 6,
        'wc' => 7,
        'pin' => 8,
        'pout' => 9,
        'tin' => 10,
        'tout' => 11,
        'flow_pattern' => 12,
        'vliq' => 13,
        'vgas' => 14,
        'vm' => 15,
        'pressure_gradient' => 16,
        'ohtc' => 17,
        'nre' => 18,
        'holdup' => 19,
        'lambda' => 20,
        'h_soil' => 21,
        'h_f' => 22,
        'npr' => 23,
        'nnu' => 24,
        'f_f_ratio' => 25,
        'rs' => 26,
        'rsw' => 27,
        'ev' => 28,
        'comment' => 29
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
        $ngdu_id = Ngdu::where('name', 'НГДУ-4')->first()->id;

        $pipes = OilPipe::with(
            'pipeType',
            'firstCoords',
            'lastCoords',
            'gu'
        )
            ->where('ngdu_id', $ngdu_id)
            ->where('trunkline', true)
            ->get();

        $isErrors = false;

        foreach ($pipes as $key => $pipe) {
            if (!$pipe->gu) {
                continue;
            }

            $query = OmgNGDU::where('gu_id', $pipe->gu->id)
                ->orderBy('date', 'desc');

            if (isset($this->input['date'])) {
                $query = $query->where('date', $this->input['date']);
            }

            $pipes[$key]->omgngdu = $query->orderBy('date', 'desc')->first();

            if (!$pipes[$key]->omgngdu) {
                $isErrors = true;
                break;
            }

            $temperature = $pipe->omgngdu->heater_output_temperature ? $pipe->omgngdu->heater_output_temperature : $pipe->omgngdu->heater_inlet_temperature;
            $temperature = $temperature ? ($temperature < 40 ? 50 : $temperature) : 50;
            $pipes[$key]->omgngdu->heater_output_temperature = $temperature;

            if (!$pipe->omgngdu->pump_discharge_pressure) {
                unset($pipes[$key]);
                continue;
            }

            if (is_null($pipe->omgngdu->pump_discharge_pressure) ||
                is_null($pipe->omgngdu->daily_fluid_production) ||
                is_null($pipe->omgngdu->bsw)) {
                $isErrors = true;
                break;
            }
        }

        if ($isErrors) {
            if (isset($this->input['cron']) and $this->input['cron']) {
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
            'pipes' => $pipes,
            'columnNames' => $this->columnNames
        ];

        $fileName = 'pipeline_calc_input.xlsx';
        $filePath = 'public/export/' . $fileName;
        Excel::store(new PipeLineCalcExport($data), $filePath);

        if (!$isErrors and isset($this->input['date'])) {
            $url = env('MANUAL_CALC_SERVICE_URL') . 'calculate?calculation_type=forward';

            $request = $this->calcRequest($url, $filePath, $fileName);

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

        if (isset($this->input['cron']) and $this->input['cron']) {
            Log::channel('calculate_hydro_yesterday:cron')->info('Расчет на ' . $this->input['date'] . ' успешно завершен.');
        }

        if (isset($this->input['calc_export']) && $this->input['calc_export'] == 'true') {
            $this->setOutput(
                [
                    'filename' => Storage::url($filePath)
                ]
            );
        }
    }

    public function calcRequest(string $url, string $filePath, string $fileName)
    {
        try {
            $client = new \GuzzleHttp\Client();

            return $client->post(
                $url,
                [
                    'content-type' => 'application/json',
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => Storage::disk('local')->get($filePath),
                            'filename' => $fileName
                        ]
                    ]
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
            return;
        }
    }

    protected function storeShortResult(array $data): void
    {
        foreach ($data as $row) {
            $oilPipe = OilPipe::find($row[self::SHORT_ID]);

            $hydroCalcResult = HydroCalcResult::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $oilPipe->id
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
        $pipe = null;

        foreach ($data as $row) {
            if (!ctype_digit($row[self::POINTS_OR_SEGMENT])) {
                $pipe = null;
                continue;
            }

            if (!$pipe) {
                $pipe = OilPipe::find($row[self::LONG_ID]);
            }

            $hydroCalcLong = HydroCalcLong::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $pipe->id,
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
