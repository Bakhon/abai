<?php

namespace App\Console\Commands\Import;

use App\Imports\WaterMeasurementImport;
use Illuminate\Console\Command;

class OilPipes extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:oil_pipes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import oil pipes data';

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
        $this->importExcel(new OilPipesImport($this), public_path('watermeasurement.xlsx'));
    }
}
