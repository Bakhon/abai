<?php

namespace App\Jobs;

use App\Exports\PipeLineReverseCalcExport;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\HydroCalcLong;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\Zu;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ReverseCalculateHydroDynamics implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Trackable;

    public $tries = 1;

    protected $params;
    protected $input;
    protected $log_channel;

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
        'height_drop',
        'SGoil',
        'SGgas',
        'SGwater'
    ];

    protected $longSchema = [
        'segment' => 0,
        'ID' => 1,
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

    const PIPE_OR_SEGMENT = 0;

    protected $shortSchema = [
        'id' => 0,
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
        'name' => 13,
        'mix_speed_avg' => 14,
        'fluid_speed' => 15,
        'gaz_speed' => 16,
        'flow_type' => 17,
        'press_change' => 18,
        'break_qty' => 19,
        'height_drop' => 20
    ];

    public $guData = [
        67 => [
            'sg_oil' => 0.8450
        ],
        38 => [
            'sg_oil' => 0.8531
        ],
        44 => [
            'sg_oil' => 0.8542
        ],
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
        $this->log_channel = (isset($this->input['cron']) and $this->input['cron']) ? 'calculate_hydro_reverse_yesterday:cron' : 'calculate_hydro_reverse';
        $message = "=========================";
        Log::channel($this->log_channel)->info($message);
        $message = "Job begins";
        Log::channel($this->log_channel)->info($message);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->input['date']) {
            return false;
        }

        $guNames = [
            'ГУ-107',
            'ГУ-24',
            'ГУ-22'
        ];

        $message = "Before get pipes";
        Log::channel($this->log_channel)->info($message);

        $isErrors = false;
        $gu_ids = Gu::whereIn('name', $guNames)->get()->pluck('id');
        $pipes = OilPipe::with('firstCoords', 'lastCoords', 'pipeType', 'gu')
            ->whereNotNull('start_point')
            ->whereNotNull('end_point')
            ->where('trunkline', false)
            ->where('water_pipe', false)
            ->whereIn('gu_id', $gu_ids)
            ->orderBy('gu_id')
            ->orderBy('zu_id')
            ->get();

        $message = "Pipes got";
        Log::channel($this->log_channel)->info($message);

        foreach ($pipes as $key => $pipe) {
            if (!$pipe->lastCoords || !$pipe->firstCoords) {
                unset($pipes[$key]);
                continue;
            }

            if ($pipe->between_points == 'well-zu') {
                $query = OmgNGDUWell::where('well_id', $pipe->well_id);

                $query = $query->where('date', '<=', $this->input['date'])
                    ->WithLastWellData($this->input['date']);

                $pipe->omgngdu = $query->orderBy('date', 'desc')->first();

                if (!$pipe->omgngdu) {
                    unset($pipes[$key]);
                    continue;
                }

                if (!$pipe->omgngdu->gas_factor) {
                    $omg_ngdu = OmgNGDU::where('gu_id', $pipe->gu_id)
                        ->where('date', '<=', $this->input['date'])
                        ->orderBy('date', 'desc')
                        ->first();

                    $omg_ngdu->sg_oil = $omg_ngdu->sg_oil ? $omg_ngdu->sg_oil : (isset($this->guData[$pipe->gu_id]) ? $this->guData[$pipe->gu_id]['sg_oil'] : 0.85);
                    $pipe->omgngdu->gas_factor = $omg_ngdu->daily_oil_production ? $omg_ngdu->daily_gas_production_in_sib / $omg_ngdu->daily_oil_production / $omg_ngdu->sg_oil : 0;
                }
            }

            if ($pipe->between_points == 'zu-gu' || $pipe->between_points == 'zu_coll-gu') {
                $query = OmgNGDU::where('gu_id', $pipe->gu_id);

                $query = $query->where('date', $this->input['date']);

                $pipe->omgngdu_gu = $query->orderBy('date', 'desc')->first();

                if (!$pipe->omgngdu_gu) {
                    $gu = Gu::find($pipe->gu_id);
                    $message =  trans('monitoring.hydro_calculation.message.no-pressure-omgdu-data').' '.$gu->name;
                    $message .= ' на ' . $this->input['date'];
                    $isErrors = true;
                    break;
                }

                if (!$pipe->omgngdu_gu->surge_tank_pressure) {
                    $month_ago_date = Carbon::parse($this->input['date'])->subDays(30)->format('YYYY-mm-dd');
                    $omg_ngdu_pressure = OmgNGDU::where('gu_id', $pipe->gu_id)
                        ->where('date', '>=', $month_ago_date)
                        ->where('date', '<=', $this->input['date'])
                        ->whereNotNull('surge_tank_pressure')
                        ->where('surge_tank_pressure', '!=', '0')
                        ->where('surge_tank_pressure', '!=', '')
                        ->get();

                    if ($omg_ngdu_pressure->count() == 0) {
                        $omg_ngdu_pressure = OmgNGDU::where('gu_id', $pipe->gu_id)
                            ->where('date', '<=', $this->input['date'])
                            ->whereNotNull('surge_tank_pressure')
                            ->where('surge_tank_pressure', '!=', '0')
                            ->where('surge_tank_pressure', '!=', '')
                            ->first();

                        $pipe->omgngdu_gu->surge_tank_pressure = $omg_ngdu_pressure->surge_tank_pressure;
                        continue;
                    }

                    $total_pressure = 0;
                    for ($i = 0; $i < $omg_ngdu_pressure->count(); $i++) {
                        $total_pressure += $omg_ngdu_pressure[$i]->surge_tank_pressure;
                    }

                    $pipe->omgngdu_gu->surge_tank_pressure = $total_pressure/$i;
                }
            }
        }

        $message = "Pipes omgngdu_gu got";
        Log::channel($this->log_channel)->info($message);

        if ($isErrors) {
            if (isset($this->input['cron']) and $this->input['cron']) {
                Log::channel($this->log_channel)->error($message);
            } else {
                $this->setOutput(
                    [
                        'error' => $message
                    ]
                );
            }

            return;
        }

        $zus = Zu::whereIn('name', ['ЗУ-22, ЗУ-22а, ЗУ-22б, ЗУ-24б, ЗУ-24г, ЗУ-107г'])->get();

        $data = [
            'pipes' => $pipes,
            'columnNames' => $this->columnNames,
            'zus' => $zus
        ];

        $fileName = 'pipeline_reverse_calc_input.xlsx';
        $filePath = 'public/export/'.$fileName;
        Excel::store(new PipeLineReverseCalcExport($data), $filePath);

        $message = 'Excel file created';
        Log::channel($this->log_channel)->info($message);

        if (!$isErrors AND isset($this->input['date'])) {
            $calcUrl = env('MANUAL_CALC_SERVICE_URL').'calculate?calculation_type=reverse';

            $request = $this->calcRequest($calcUrl, $filePath, $fileName);
            $message = 'Data calculated, begins saving';
            Log::channel($this->log_channel)->info($message);

            $data = json_decode($request->getBody()->getContents());
            $short = $data->short->data;
            $long = $data->long->data;

            if ($short) {
                $this->storeShortResult($short);
            }

            if ($long) {
                $this->storeLongResult($long);
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
                            'name'     => 'file',
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
        $message = 'Begins saving short data';
        Log::channel($this->log_channel)->info($message);

        foreach ($data as $row) {
            $pipe = OilPipe::find($row[$this->shortSchema['id']]);

            $calcResult = HydroCalcResult::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $pipe->id,
                ]
            );

            foreach ($this->shortSchema as $param => $index) {
                if ($param != 'name' && $param != 'id') {
                    $calcResult->$param = $row[$index];
                }
            }

            $calcResult->save();
        }

        $message = 'Short data saved';
        Log::channel($this->log_channel)->info($message);
    }

    protected function storeLongResult(array $data): void
    {
        $message = 'Begins saving long data';
        Log::channel($this->log_channel)->info($message);

        $pipe = null;
        foreach ($data as $row) {
            if (!ctype_digit($row[$this->longSchema['segment']])) {
                $pipe = null;
                continue;
            }

            if (!$pipe) {
                $pipe = OilPipe::find($row[$this->longSchema['ID']]);
            }

            $hydroCalcLong = HydroCalcLong::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $pipe->id,
                    'segment' => $row[$this->longSchema['segment']]
                ]
            );

            foreach ($this->longSchema as $param => $index) {
                if ($param == 'ID') {
                    continue;
                }

                $hydroCalcLong->$param = $row[$index];
            }

            $hydroCalcLong->save();
        }

        $message = 'Long data saved';
        Log::channel($this->log_channel)->info($message);
    }
}

