<?php

namespace App\Jobs;

use App\Exports\ManualCalculateExport;
use App\Filters\ManualHydroCalculationFilter;
use App\Imports\HydroCalcResultImport;
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
    public $errors = [];

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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!isset($this->input['date'])) {
            return;
        }

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

        if ($this->input['checkbox_selected']) {
            $query->whereIn('gu_id', $this->input['checkbox_selected']);
        }

        $pipes = $query->get();

        $pipes->load('pipeType');
        $this->loadRelations($pipes);

        if (!$pipes) {
            return;
        }

        $calcUrl = $this->getUrl($pipes);

        $data = [
            'pipes' => $pipes,
            'columnNames' => $this->columnNames
        ];

        $fileName = 'pipeline_calc_input.xlsx';
        $filePath = 'public/export/' . $fileName;
        Excel::store(new ManualCalculateExport($data), $filePath);

        $fileurl = env('KMG_SERVER_URL') . Storage::url($filePath);
        $url = $calcUrl . 'url_file/?url=' . $fileurl;

        $client = new \GuzzleHttp\Client();

        $request = $this->calcRequest($client, $url);

        $data = json_decode($request->getBody()->getContents());
        $short = $data->short->data;

        if ($short) {
            $this->storeShortResult($short);
        }
    }

    public function calcRequest($client, string $url)
    {
        try {
            return $client->post(
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
    }

    protected function getUrl($pipes): string
    {
        $calcUrl = env('HYDRO_CALC_SERVICE_URL');
        foreach ($pipes as $pipe) {
            if ($pipe->between_points == 'zu-gu' and ($pipe->gu->omgngdu[0]->surge_tank_pressure ?? null)) {
                $calcUrl = env('MANUAL_CALC_SERVICE_URL');
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

    public function loadRelations(Collection $pipes)
    {
        $guIds = [];
        foreach ($pipes as $key => $pipe) {
            if ($pipe->between_points != 'well-zu') {
                continue;
            }

            $query = OmgNGDUWell::where('well_id', $pipe->well_id);

            if (isset($this->input['date'])) {
                $query = $query->where('date', $this->input['date']);
            }

            $pipe->omgngdu = $query->orderBy('date', 'desc')->first();

            if ($pipe->omgngdu) {
                continue;
            }

            $guIds[] = $pipe->gu_id;
        }

        foreach ($pipes as $key => $pipe) {
            if (in_array($pipe->gu_id, $guIds)) {
                unset($pipes[$key]);
            }
        }
    }
}
