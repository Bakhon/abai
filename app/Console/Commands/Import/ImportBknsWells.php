<?php

namespace App\Console\Commands\Import;

use App\Imports\WaterBknsWellsImport;
use App\Models\ComplicationMonitoring\BknsWell;
use Illuminate\Console\Command;

class ImportBknsWells extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:bkns_wells';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import BKNS water wells';

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
        BknsWell::truncate();
        $this->importExcel(new WaterBknsWellsImport($this), public_path('imports/bkns_wells.xlsx'));
    }
}
