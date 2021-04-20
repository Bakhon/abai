<?php

namespace App\Jobs;

use App\Exports\PipeLineCalcExport;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\TrunklinePoint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->prepareStatus();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $points = TrunklinePoint::with('map_pipe.pipeType', 'map_pipe.firstCoords', 'map_pipe.lastCoords', 'gu', 'trunkline_end_point')->get();

        foreach($points as $key => $point) {
            if (!$points[$key]->gu) {
                continue;
            }

            $points[$key]->lastOmgngdu = OmgNGDU::where('gu_id', $points[$key]->gu->id)
                ->orderBy('date', 'desc')
                ->first();

            if (!$points[$key]->lastOmgngdu) {
                continue;
            }

            $temperature = $points[$key]->lastOmgngdu->heater_output_temperature;
            $temperature = $temperature ? ($temperature < 40 ? 50 : $temperature) : 50;
            $points[$key]->lastOmgngdu->heater_output_temperature = $temperature;
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

        $fileName = '/export/pipeline_calc_input.xlsx';
        Excel::store(new PipeLineCalcExport($data), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
