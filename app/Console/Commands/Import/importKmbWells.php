<?php

namespace App\Console\Commands\Import;

use App\Imports\WaterKmbWellsImport;
use App\Models\ComplicationMonitoring\KmbWell;
use Illuminate\Console\Command;

class importKmbWells extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:kmb_wells';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import KMB water wells';

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
        KmbWell::truncate();
        $this->importExcel(new WaterKmbWellsImport($this), public_path('imports/kmb_wells.xlsx'));
    }
}
