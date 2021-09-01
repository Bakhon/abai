<?php

namespace App\Jobs;

use App\Exports\ManualCalculateExport;
use App\Exports\PipeLineCalcExport;
use App\Filters\ManualHydroCalculationFilter;
use App\Imports\HydroCalcResultImport;
use App\Models\ComplicationMonitoring\HydroCalcLong;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
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
use Illuminate\Support\Facades\Log;

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
        $query = ManualOilPipe::query()
            ->with('firstCoords', 'lastCoords');


        if (isset($this->input['date'])) {
            $date = $this->input['date'];
            $query = $query->with(['gu.omgngdu' => function ($q) use ($date) {
                $q->where('date', $date);
            }]);
        } else {
            $query = $query->with('gu.lastOmgngdu');
        }

        $pipes = $this
            ->getFilteredQuery($this->input, $query)
            ->whereNotNull('start_point')
            ->whereNotNull('end_point')
            ->orderBy('gu_id')
            ->get();

        $pipes->load('pipeType');

        foreach ($pipes as $key => $pipe) {
            if ($pipe->between_points != 'well-zu') {
                continue;
            }

            $query = OmgNGDUWell::where('well_id', $pipe->well_id);

            if (isset($this->input['date'])) {
                $query = $query->where('date', $this->input['date']);
            }

            $pipe->omgngdu = $query->orderBy('date', 'desc')->first();

            if (!$pipe->omgngdu) {

                $message = $pipe->start_point . ' ' . trans('monitoring.hydro_calculation.message.no-omgdu-data');

                if (isset($input['date'])) {
                    $message .= ' на ' . $input['date'];
                }

                $this->setOutput(
                    [
                        'error' => $message
                    ]
                );

                return;
            }
        }

        $data = [
            'pipes' => $pipes,
            'columnNames' => $this->columnNames
        ];

        $fileName = 'manual_calc_input.xlsx';
        $filePath = 'public/export/' . $fileName;
        Excel::store(new ManualCalculateExport($data), $filePath);

        if (isset($this->input['date'])) {

            $fileurl = env('KMG_SERVER_URL') . Storage::url($filePath);
            $url = env('MANUAL_CALC_SERVICE_URL') . 'url_file/?url=' . $fileurl;

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

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new ManualHydroCalculationFilter($query, $filter))->filter();
    }
}
