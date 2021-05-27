<?php

namespace App\Console\Commands\Import;

use App\Imports\ReverseCalculationImport;
use App\Models\ComplicationMonitoring\ReverseCalculation;
use Illuminate\Console\Command;

class ImportReverseCalculation extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:reverse_calculation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import reverse calculation table';

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
        ReverseCalculation::truncate();
        $this->importExcel(new ReverseCalculationImport($this), public_path('imports/reverse_calculation.xlsx'));
    }
}
