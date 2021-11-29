<?php

namespace App\Console\Commands\Import;

use App\Imports\WaterPipesWellsImport;
use App\Imports\WaterWellsImport;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\WaterWell;
use Illuminate\Console\Command;

class ImportWaterWells extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:water_wells';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import water wells';

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
        WaterWell::truncate();
        OilPipe::where('water_pipe', true)->forceDelete();

        $pipes_ids = OilPipe::get()->pluck('id');
        $manual_pipes_ids = ManualOilPipe::get()->pluck('id');
        $pipes_ids = $pipes_ids->merge($manual_pipes_ids);
        PipeCoord::whereNotIn('oil_pipe_id', $pipes_ids)->forceDelete();

        $this->importExcel(new WaterPipesWellsImport($this), public_path('imports/water_wells.xlsx'));
    }
}
