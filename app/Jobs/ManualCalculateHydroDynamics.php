<?php

namespace App\Jobs;

use App\Exports\ManualCalculateExportCalc;
use App\Filters\ManualHydroCalculationFilter;
use App\Imports\HydroCalcResultImport;
use App\Models\ComplicationMonitoring\ManualHydroCalcLong;
use App\Models\ComplicationMonitoring\ManualHydroCalcResult;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ManualCalculateHydroDynamics implements ShouldQueue
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
        'height_drop',
        'SGoil',
        'SGgas',
        'SGwater'
    ];

    protected $longSchema = [
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

    const PIPE_OR_SEGMENT = 0;

    protected $shortSchema = [
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $input)
    {
        $this->prepareStatus();
        $this->input = $input;
        if (isset($this->input['gu_id'])) {
            $this->input['gu_ids'] = [$this->input['gu_id']];
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!isset($this->input['date'])) {
            $this->setOutput(
                [
                    'error' => trans('monitoring.calculate_messages.no_date')
                ]
            );
            return;
        }

        $pipes = $this->getPipes();

        $pipes->load('pipeType');
        $alerts = $this->loadRelations($pipes);

        if (count($alerts)){
            $this->setOutput(
                [
                    'alerts' => $alerts
                ]
            );
            return;
        }

        if (!$pipes) {
            return;
        }

        $this->calculate($pipes);
    }

    public function getPipes()
    {
        $query = ManualOilPipe::query()
            ->with('firstCoords', 'lastCoords');

        $date = $this->input['date'];
        $query = $query->with(['gu.omgngdu' => function ($q) use ($date) {
            $q->where('date', $date);
        }]);

        $query = $this
            ->getFilteredQuery($this->input, $query)
            ->whereNotNull('start_point')
            ->whereNotNull('end_point')
            ->orderBy('gu_id');

        if (!empty($this->input['gu_ids'])) {
            $query->whereIn('gu_id', $this->input['gu_ids']);
        }

        return $query->get();
    }

    public function calculate($pipes)
    {
        $calcUrl = $this->getUrl($pipes);

        $data = [
            'pipes' => $pipes,
            'columnNames' => $this->columnNames
        ];

        $fileName = 'pipeline_calc_input.xlsx';
        $filePath = 'public/export/' . $fileName;
        Excel::store(new ManualCalculateExportCalc($data), $filePath);

        $request = $this->calcRequest($calcUrl, $filePath, $fileName);

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

    protected function getUrl($pipes): string
    {
        $calcUrl = env('HYDRO_CALC_SERVICE_URL');
        foreach ($pipes as $pipe) {
            if ($pipe->between_points == 'zu-gu' and ($pipe->gu->omgngdu[0]->surge_tank_pressure != null)) {
                $calcUrl = env('MANUAL_CALC_SERVICE_URL').'calculate?calculation_type=reverse';
                break;
            }
        }

        return $calcUrl;
    }


    protected function getFilteredQuery($filter, $query = null)
    {
        return (new ManualHydroCalculationFilter($query, $filter))->filter();
    }

    protected function storeShortResult(array $data): void
    {
        foreach ($data as $row) {
            $pipeName = $row[$this->shortSchema['name']];
            $pipe = ManualOilPipe::where('name', $pipeName)->first();

            $calcResult = ManualHydroCalcResult::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $pipe->id,
                ]
            );

            foreach ($this->shortSchema as $param => $index) {
                if ($param != 'name') {
                    $calcResult->$param = $row[$index];
                }
            }

            $calcResult->save();
        }
    }

    protected function storeLongResult(array $data): void
    {
        foreach ($data as $key => $row) {
            if (!ctype_digit($row[self::PIPE_OR_SEGMENT])) {
                $points = explode(" - ", $row[self::PIPE_OR_SEGMENT]);
                $pipe = ManualOilPipe::where('start_point', $points[0])
                    ->where('end_point', $points[1])
                    ->first();

                continue;
            }

            if (!$pipe) {
                $points = explode(" - ", $data[$key - 1][self::PIPE_OR_SEGMENT]);
                $message = trans('monitoring.calculate_messages.no_such_pipe',
                    [
                        'start_point' => $points[0],
                        'end_point' => $points[1]
                    ]);

                $this->setOutput(
                    [
                        'error' => $message
                    ]
                );
                return;
            }

            $hydroCalcLong = ManualHydroCalcLong::firstOrCreate(
                [
                    'date' => Carbon::parse($this->input['date'])->format('Y-m-d'),
                    'oil_pipe_id' => $pipe->id,
                    'segment' => $row[self::PIPE_OR_SEGMENT]
                ]
            );

            foreach ($this->longSchema as $param => $index) {
                $hydroCalcLong->$param = $row[$index];
            }

            $hydroCalcLong->save();
        }
    }


    public function loadRelations(Collection $pipes)
    {
        $guIds = [];
        $alerts = [];
        foreach ($pipes as $key => $pipe) {
            if (!$pipe->lastCoords || !$pipe->firstCoords) {
                unset($pipes[$key]);
                continue;
            }

            if ($pipe->between_points != 'well-zu') {
                if ($pipe->gu && $pipe->gu->omgngdu && !$pipe->gu->omgngdu[0]->surge_tank_pressure) {
                    $message = $pipe->end_point . ' ' . trans('monitoring.hydro_calculation.message.no-pressure-on-gu-omgdu');
                    if (isset($this->input['date'])) {
                        $message .= ' на ' . $this->input['date'];
                    }
                    $alerts[] = [
                        'message' => $message.' !',
                        'variant' => 'danger'
                    ];
                }
                continue;
            }

            $query = OmgNGDUWell::where('well_id', $pipe->well_id);

            if (isset($this->input['date'])) {
                $query = $query->where('date', $this->input['date']);
            }

            $pipe->omgngdu = $query->orderBy('date', 'desc')->first();

            if (!$pipe->omgngdu) {
                $message = $pipe->start_point . ' ' . trans('monitoring.hydro_calculation.message.no-omgdu-data');

                if (isset($this->input['date'])) {
                    $message .= ' на ' . $this->input['date'];
                }

                $alerts[] = [
                    'message' => $message . ' !',
                    'variant' => 'danger'
                ];
                continue;
            }

            $guIds[] = $pipe->gu_id;
        }

        foreach ($pipes as $key => $pipe) {
            if (!in_array($pipe->gu_id, $guIds)) {
                unset($pipes[$key]);
            }
        }

        return $alerts;
    }
}
