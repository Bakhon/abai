<?php

namespace App\Console\Commands\Import;

use App\Imports\PipePassportsImport;
use App\Models\ComplicationMonitoring\PipePassport;
use Illuminate\Console\Command;

class PipePassports extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pipe_passports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import pipe passports';

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
        activity()->disableLogging();
        PipePassport::truncate();

        $this->importExcel(new PipePassportsImport($this), public_path('imports/pipe_passports.xlsx'));
    }
}
