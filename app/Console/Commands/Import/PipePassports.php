<?php

namespace App\Console\Commands\Import;

use App\Imports\Ngdu4WellsImport;
use App\Imports\TrunklineImport;
use App\Models\ComplicationMonitoring\PipeType;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Models\ComplicationMonitoring\Well;
use App\Models\ComplicationMonitoring\Zu;
use Illuminate\Console\Command;
use App\Imports\GuWellsImport;
use Illuminate\Support\Facades\DB;

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

        $this->importExcel(new PipePassportsImport($this), public_path('imports/pipe_passports.xlsx'));
    }
}
