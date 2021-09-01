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
            $this->setOutput(
                [
                    'data' => $data
                ]
            );
        }
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new ManualHydroCalculationFilter($query, $filter))->filter();
    }
}
