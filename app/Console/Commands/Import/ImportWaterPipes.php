<?php

namespace App\Console\Commands\Import;

use App\Models\ComplicationMonitoring\BG;
use App\Models\ComplicationMonitoring\BknsWell;
use App\Models\ComplicationMonitoring\KmbWell;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\WaterWell;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportWaterPipes extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:water_pipes';

    public $water_objects = [
        'WaterWell' => 'water_well',
        'KmbWell' => 'kmb_well',
        'BknsWell' => 'bkns_well',
        'BG' => 'bg_well'
    ];

    public $model_namespace = 'App\Models\ComplicationMonitoring\\';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import water pipes";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $json = File::get(base_path() . '/public/imports/water_pipes.json');
        $data = json_decode($json);
        OilPipe::where('water_pipe', true)->forceDelete();

        foreach ($data->features as $feature) {
            $pipe = new OilPipe();
            $pipe->water_pipe = true;
            $pipe->between_points = 'water-pipe';
            $pipe->save();

            foreach ($feature->geometry->coordinates[0] as $key => $coords) {
                $pipe_coord = new PipeCoord();
                $pipe_coord->h_distance = $feature->properties->LENGTH;
                $pipe_coord->m_distance = $feature->properties->LENGTH;

                if ($key === 0) {
                    foreach( $this->water_objects as $key => $value ){
                        $model_name = $this->model_namespace.$key;
                        $$value = $model_name::where('lat', $coords[1])->where('lon', $coords[0])->first();
                        if ($$value) {
                            $pipe->start_point = $$value->name;
                            break;
                        }
                    };

                    $pipe_coord->h_distance = 0;
                    $pipe_coord->m_distance = 0;
                }

                if ($key === count($feature->geometry->coordinates[0]) -1 ) {
                    foreach( $this->water_objects as $key => $value ){
                        $model_name = $this->model_namespace.$key;
                        $$value = $model_name::where('lat', $coords[1])->where('lon', $coords[0])->first();

                        if ($$value) {
                            $pipe->end_point = $$value->name;
                            break;
                        }
                    };
                }

                $pipe_coord->elevation = 0;
                $pipe_coord->lat = $coords[1];
                $pipe_coord->lon = $coords[0];
                $pipe_coord->oil_pipe_id = $pipe->id;
                $pipe_coord->save();
            }

            $pipe->save();
        }

        $pipes_ids = OilPipe::get()->pluck('id');
        $manual_pipes_ids = ManualOilPipe::get()->pluck('id');
        $pipes_ids = $pipes_ids->merge($manual_pipes_ids);
        PipeCoord::whereNotIn('oil_pipe_id', $pipes_ids)->forceDelete();

        $this->info('Pipes Imported');
    }
}
