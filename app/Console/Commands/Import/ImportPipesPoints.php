<?php

namespace App\Console\Commands\Import;

use App\Imports\PipesPointsImport;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\TrunklinePoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportPipesPoints extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pipe_points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import pipes start and end points';

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
        $pipes_ids = OilPipe::get()->pluck('id');
        $manual_pipes_ids = ManualOilPipe::get()->pluck('id');
        $pipes_ids = $pipes_ids->merge($manual_pipes_ids);
        PipeCoord::whereNotIn('oil_pipe_id', $pipes_ids)->forceDelete();
        TrunklinePoint::truncate();

        $this->importExcel(new PipesPointsImport($this), public_path('imports/thunkline_points.xlsx'));
    }
}
