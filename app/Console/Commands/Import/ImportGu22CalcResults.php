<?php

namespace App\Console\Commands\Import;

use App\Imports\Gu22CalcResultsImport;
use App\Models\ComplicationMonitoring\KmbWell;
use Illuminate\Console\Command;

class ImportGu22CalcResults extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:gu_22_calc_results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import GU-22 calc results';

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
        $this->importExcel(new Gu22CalcResultsImport($this), public_path('imports/gu_22_calc_results.xlsx'));
    }
}
