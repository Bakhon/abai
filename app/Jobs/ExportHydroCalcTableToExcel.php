<?php

namespace App\Jobs;

use App\Exports\PipeLineCalcExport;
use App\Exports\PipeLineResultExport;
use App\Imports\HydroCalcResultImport;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\TrunklinePoint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ExportHydroCalcTableToExcel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Trackable;

    public $tries = 1;

    protected $params;
    protected $input;

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
        $points = TrunklinePoint::with('map_pipe.pipeType', 'map_pipe.firstCoords', 'map_pipe.lastCoords', 'gu', 'trunkline_end_point')->get();
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
                continue;
            }

            $temperature = $points[$key]->omgngdu->heater_output_temperature;
            $temperature = $temperature ? ($temperature < 40 ? 50 : $temperature) : 50;
            $points[$key]->omgngdu->heater_output_temperature = $temperature;

            if (!$points[$key]->omgngdu->pump_discharge_pressure ||
                !$points[$key]->omgngdu->daily_fluid_production ||
                !$points[$key]->omgngdu->bsw) {
                $isErrors = true;
            }
        }

        $columnNames = [
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

        $data = [
            'points' => $points,
            'columnNames' => $columnNames
        ];

        $fileName = 'pipeline_calc_input.xlsx';
        $filePath = 'public/export/'.$fileName;
//        Excel::store(new PipeLineCalcExport($data), $filePath);
//        copy(Storage::path($filePath), env('HYDRO_CALC_PATH').$fileName);

        if ($isErrors AND isset($this->input['date'])) {
            $command = escapeshellcmd(env('HYDRO_CALC_PATH').env('HYDRO_CALC_PY_FILENAME'));
            $output = shell_exec($command);

            if ($output) {
                $this->setOutput(
                    [
                        'error' => $output
                    ]
                );
            }

            if (file_exists(env('HYDRO_CALC_PATH').'calc_results.csv')) {
                $this->importResult();
                Excel::store(new PipeLineResultExport($this->input['date']), $filePath);
            }
        }

        $this->setOutput(
            [
                'filename' => Storage::url($filePath)
            ]
        );
    }

    protected function importResult ()
    {
        Excel::import(new HydroCalcResultImport($this->input['date']), env('HYDRO_CALC_PATH').'calc_results.csv');
    }
}
