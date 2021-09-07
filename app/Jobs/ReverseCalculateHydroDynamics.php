<?php

namespace App\Jobs;

use App\Exports\PipeLineCalcExport;
use App\Exports\PipeLineReverseCalcExport;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\OilPipe;
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
        return false;

        $guNames = [
            'ГУ-107',
            'ГУ-24',
            'ГУ-22'
        ];

        $pipes = OilPipe::with('gu, pipeType', 'firstCoords', 'lastCoords', 'well.omgngdu_well')->whereHas('gu', function($q) use ($guNames){
            $q->whereIn('name', $guNames);
        })->get();

        $isErrors = false;

        foreach($pipes as $key => $pipe) {

            $query = OmgNGDUWell::where('well_id', $pipe->well->id)
                ->orderBy('date', 'desc');

            if (isset($this->input['date'])) {
                $query = $query->where('date', $this->input['date']);
            }

            $pipes[$key]->well->omgngdu_well = $query->orderBy('date', 'desc')->first();

            if (!$pipes[$key]->well->omgngdu_well) {
                $isErrors = true;
                break;
            }

            $temperature = $pipes[$key]->well->omgngdu_well->heater_output_temperature;
            $temperature = $temperature ? ($temperature < 40 ? 50 : $temperature) : 50;
            $pipes[$key]->well->omgngdu_well->heater_output_temperature = $temperature;

            if (!$pipes[$key]->well->omgngdu_well->pump_discharge_pressure ||
                !$pipes[$key]->well->omgngdu_well->daily_fluid_production ||
                !$pipes[$key]->well->omgngdu_well->bsw) {
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
            'pipes' => $pipes,
            'columnNames' => $this->columnNames
        ];

        $fileName = 'pipeline_reverse_calc_input.xlsx';
        $filePath = 'public/export/'.$fileName;
        Excel::store(new PipeLineReverseCalcExport($data), $filePath);

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

            $data = json_decode($request->getBody()->getContents())[0]->data;

            if ($data) {
                $this->storeResult($data);
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

    protected function storeResult (array $data)
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
}

