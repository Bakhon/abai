<?php

namespace App\Console\Commands\Import;

use App\Imports\WaterWellsImport;
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
        $this->importExcel(new WaterWellsImport($this), public_path('imports/water_wells.xlsx'));
    }
}
